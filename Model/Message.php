<?php

require_once 'Core' . DIRECTORY_SEPARATOR . 'Model.php';

class Message extends Model
{

    public function getMessages($userId = null)
    {
        if (!$userId) {
            $sql = "SELECT m.id, m.message, m.date ,u.login "
                    . "FROM messages m "
                    . "LEFT JOIN users u ON m.user = u.id "
                    . "ORDER BY m.date ";
            $messages = $this->exec($sql);
        } else {
            $sql = "SELECT m.id, m.message, u.login "
                    . "FROM messages m "
                    . "LEFT JOIN users u ON m.user = u.id "
                    . "WHERE user=? "
                    . "ORDER BY m.date ";
            $messages = $this->exec($sql, array($userId));
        }

        if ($messages->rowCount() > 0) {
            return $messages->fetchAll(PDO::FETCH_OBJ);
        } else {
            throw new Exception("Model/Message.php : Messages not found");
        }
    }

    public function addMessage($userId, $message)
    {
        $sqlInsert = 'INSERT INTO messages(message, user)'
                . ' values(?, ?)';
        $sqlUpdate = 'UPDATE users SET last_connected = now() WHERE id=?';

        return $this->exec($sqlInsert, array($message, $userId)) && $this->exec($sqlUpdate, array($userId));
    }

    public function getLastMessage()
    {
        $sql = "SELECT m.id, m.message, m.date, u.login "
                . "FROM messages m "
                . "LEFT JOIN users u ON m.user = u.id "
                . "ORDER BY date DESC "
                . "LIMIT 1";
        $message = $this->exec($sql);

        if ($message->rowCount() == 1) {
            return $message->fetch(PDO::FETCH_OBJ);
        } else {
            throw new Exception("Model/Message.php : LastId not found");
        }
    }

    public function getLastMessages($lastId)
    {
        $sql = "SELECT m.id, m.message, m.date, u.login "
                . "FROM messages m "
                . "LEFT JOIN users u ON m.user = u.id "
                . "WHERE m.id>? "
                . "ORDER BY m.date ";
        $message = $this->exec($sql, array($lastId));

        if ($message->rowCount() > 0) {
            return $message->fetchAll(PDO::FETCH_OBJ);
        }
    }

}
