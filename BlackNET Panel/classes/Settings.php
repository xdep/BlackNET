<?php
class Settings extends Database
{
    public function getSettings($id)
    {
        $pdo = $this->Connect();
        $sql = "SELECT * FROM settings WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $data = $stmt->fetch();
        return $data;
    }

    public function updateSettings($id, $recaptchaprivate, $recaptchapublic, $recaptchastatus, $panel_status, $c_password)
    {
        $pdo = $this->Connect();
        $sql = "UPDATE settings SET
        recaptchaprivate = :private,
        recaptchapublic = :public,
        recaptchastatus = :status,
        panel_status = :pstatus,
        c_password = :cp
        WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            "private" => $recaptchaprivate,
            "public" => $recaptchapublic,
            "status" => $recaptchastatus,
            "pstatus" => $panel_status,
            "cp" => $c_password,
            "id" => $id
        ]);
        return 'Settings Updated';
    }
}
