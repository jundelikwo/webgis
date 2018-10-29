<?php
    require_once('Database.php');

    class Model {
        public static function findAll($order=false){
            global $database;
            $sql = "SELECT * FROM " . static::$tableName;
            if(is_array($order) && !empty($order)){
                $sql .= " ORDER BY " . $order[0];
                $sql .= isset($order[1]) && $order[1] == 1 ? " ASC" : " DESC";
            }
            $smt = $database->connection->prepare($sql);
            $smt->execute();
            
            $result = $smt->fetchAll(PDO::FETCH_CLASS);
            return static::instantiate($result);
        }

        public static function findAllByField($fieldName,$fieldValue,$order=false,$except=false){
            global $database;
            $sql = "SELECT * FROM " . static::$tableName . " WHERE " . $fieldName . "=?";
            if(is_array($except)){
                foreach($except as $field => $value){
                    $sql .= " AND " . $field . " !=?";
                }
            }
            if(is_array($order) && !empty($order)){
                $sql .= " ORDER BY " . $order[0];
                $sql .= isset($order[1]) && $order[1] == 1 ? " ASC" : " DESC";
            }
            $smt = $database->connection->prepare($sql);
            $i=1;
            $smt->bindParam($i,$fieldValue);
            if(is_array($except)){
                foreach($except as $field => $value){
                    $smt->bindParam(++$i,$value);
                }
            }
            $smt->execute();
            
            $result = $smt->fetchAll(PDO::FETCH_CLASS);
            return static::instantiate($result);
        }

        public static function search($params,$order=false,$where=[]){
            global $database;
            $sql = "SELECT * FROM " . static::$tableName . " WHERE (";
            $numParams = count($params);
            $index = 1;
            foreach($params as $field => $value){
                // . " WHERE " . $fieldName . "=?"
                if($index > 1){
                    $sql .= " || ";
                }
                $sql .= $field . " LIKE ?";
                $search = explode(' ',$value);
                $count = count($search);
                for($i=0; $i<$count; $i++){
                    $elem = trim($search[$i]);
                    if(empty($elem) || strlen($elem) < 4 || $elem === $value){
                        continue;
                    }
                    $sql .= " || " . $field . " LIKE ?";
                }
                $index++;
            }
            $sql .= ')';
            foreach($where as $field => $value){
                $sql .= ' AND ' . $field . '=?';
            }
            if(is_array($order) && !empty($order)){
                $sql .= " ORDER BY " . $order[0];
                $sql .= isset($order[1]) && $order[1] == 1 ? " ASC" : " DESC";
            }
            $smt = $database->connection->prepare($sql);
            $bind = 0;
            foreach($params as $field => $value){
                $val = '%'.$value.'%';
                $smt->bindValue(++$bind,$val);
                $search = explode(' ',$value);
                $count = count($search);
                for($i=0; $i<$count; $i++){
                    $elem = trim($search[$i]);
                    if(empty($elem) || strlen($elem) < 4 || $elem === $value){
                        continue;
                    }
                    $val = '%'.$elem.'%';
                    $smt->bindValue(++$bind,$val);
                }
            }
            foreach($where as $field => $value){
                $smt->bindValue(++$bind,$value);
            }
            $smt->execute();
            
            $result = $smt->fetchAll(PDO::FETCH_CLASS);
            return static::instantiate($result);
        }

        public static function findById($id){
            global $database;
            $sql = "SELECT * FROM " . static::$tableName . " WHERE id=?";
            $smt = $database->connection->prepare($sql);
            $smt->bindParam(1,$id);
            $smt->execute();

            $result = $smt->fetchAll(PDO::FETCH_CLASS);
            if(!count($result)){
                return false;
            }
            return static::getClassFromArray($result[0]);
        }

        private static function instantiate($datas){
            $objs = [];
            foreach($datas as $key=>$value){
                $objs[] = static::getClassFromArray(get_object_vars($value));
            };
            return $objs;
        }

        private static function getClassFromArray($array){
            $child = new static;
            foreach($array as $propKey => $propVal){
                $child->$propKey = $propVal;
            }
            return $child;
        }

        public function save($msg=false){
            isset($this->id) ? $this->update($msg) : $this->create($msg);
        }
        
        protected function update($msg){
            global $database;
            global $session;
            $message = !empty($msg) ? $msg : get_class($this) . ' successfully saved';

            $attributes = static::$dbFields;
            unset($attributes[0]);
            $count = count($attributes);

            $sql = "UPDATE " . static::$tableName . " SET ";
            for($i=1; $i<=$count; $i++){
                if($i === $count){
                    $sql .= $attributes[$i] . "=? ";
                }else{
                    $sql .= $attributes[$i] . "=?, ";
                }
            }
            //$sql .= " WHERE id=?";
            $sql .= " WHERE id=" . $this->id;
            $smt = $database->connection->prepare($sql);
            foreach($attributes as $attribute => $value){
                echo $attribute . " : " . $this->$value . "<br>";
                $smt->bindParam($attribute, $this->$value);
            }
            //$smt->bindParam(count($attributes),$this->id);

            $smt->execute();
            $session->flash('message', $message);
        }

        protected function create(){
            global $database;

            $attributes = static::$dbFields;
            unset($attributes[0]);

            $sql = 'INSERT INTO ' . static::$tableName . " (";
            $sql .= join(", " , $attributes);
            $sql .= ") VALUES (";
            $sql .= str_repeat('?,',count($attributes)-1);
            $sql .= "?)";
            
            $smt = $database->connection->prepare($sql);
            foreach($attributes as $attribute => $value){
                $smt->bindParam($attribute, $this->$value);
            }
            $smt->execute();
            $this->id = $database->connection->lastInsertId();
        }
        
        public function delete(){
            global $database;
            global $session;
            
            $sql = "DELETE FROM " . static::$tableName . " WHERE id = ?";
            $smt = $database->connection->prepare($sql);
            $smt->bindParam(1, $this->id);
            $smt->execute();
            $session->flash('message', get_class($this) . ' successfully deleted');
        }
    }

?>