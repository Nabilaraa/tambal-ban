<?php

require_once __DIR__ . "/../Core/Service.php";
require_once __DIR__ . "/../Core/Helpers/Arr.php";
require_once __DIR__ . "/../Models/TirePatch.php";


class TirePatchService extends Service
{
    public static function findOneById($id)
    {
        $stmt = static::getConnection()->prepare("SELECT * FROM `tire_patches` WHERE `id` = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($result) {
            return TirePatch::serialize($result);
        }
        return null;
    }

    public static function search($keyword)
    {
        $keyword = "%$keyword%";

        $stmt = static::getConnection()->prepare("SELECT * FROM `tire_patches` WHERE `address` LIKE ?");
        $stmt->bind_param("s", $keyword);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        $result = Arr::fetchAssoc($result);

        return TirePatch::serializeMany($result);
    }

    /**
     * To find out whether the tire patch belongs to that user.
     *
     * @param User $user
     * @param TirePatch $tirePatch
     * @return boolean
     */
    public static function isOwnedBy($user, $tirePatch)
    {
        return $user->getId() === $tirePatch->getUserId();
    }

    public static function edit($tirePatch)
    {
        $stmt = static::getConnection()->prepare("UPDATE `tire_patches` SET `name` = ?, `address` = ?, `description` = ?, `whatsapp_number` = ? WHERE id = ?");

        $name = $tirePatch->getName();
        $address = $tirePatch->getAddress();
        $description = $tirePatch->getDescription();
        $whatsappNumber = $tirePatch->getWhatsappNumber();
        $id = $tirePatch->getId();

        $stmt->bind_param("ssssi", $name, $address, $description, $whatsappNumber, $id);

        $process = $stmt->execute();
        $stmt->close();

        // Jika proses sukses.
        if ($process) {
            return true;
        }

        // Jika proses gagal.
        return false;
    }

    public static function insert($tirePatch)
    {
        $stmt = static::getConnection()->prepare("INSERT INTO `tire_patches` (`user_id`, `name`, `address`, `description`, `whatsapp_number`, `created`) VALUES (?, ?, ?, ?, ?, ?)");

        $userId = $tirePatch->getUserId();
        $name = $tirePatch->getName();
        $address = $tirePatch->getAddress();
        $description = $tirePatch->getDescription();
        $whatsappNumber = $tirePatch->getWhatsappNumber();
        $created = $tirePatch->getCreated();

        $stmt->bind_param("issssi", $userId, $name, $address, $description, $whatsappNumber, $created);

        $process = $stmt->execute();
        $stmt->close();

        // Jika proses sukses.
        if ($process) {
            return true;
        }

        // Jika proses gagal.
        return false;
    }

    public static function ownedBy($userId)
    {
        $stmt = static::getConnection()->prepare("SELECT * FROM `tire_patches` WHERE `user_id` = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        $result = $stmt->get_result();
        $stmt->close();

        $result = Arr::fetchAssoc($result);

        return TirePatch::serializeMany($result);
    }

    public static function delete($id)
    {
        $tirePatch = self::findOneById($id);

        if (!$tirePatch) return false;

        $stmt = self::getConnection()->prepare("DELETE FROM `tire_patches` WHERE `id` = ? LIMIT 1");
        $stmt->bind_param("i", $id);

        $process = $stmt->execute();
        $stmt->close();

        if ($process) {
            return true;
        }

        // Jika proses gagal.
        return false;
        if ($process) {
            return true;
        }
        return false;
    }
}
