<?php
class Camera {
    /**
     * @return array
     */
    
    // Récupération de toutes les caméras
    public function getCameras() {
        global $oPDO;
        $oPDOStatement = $oPDO->query("SELECT id, brand, storage, price FROM camera ORDER BY id ASC");
        $cameras = $oPDOStatement->fetchAll(PDO::FETCH_ASSOC);
        return $cameras;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getCamera($id) {
        global $oPDO;

        $oPDOStatement = $oPDO->prepare('SELECT id, brand, storage, price FROM camera WHERE id = :id');
        $oPDOStatement->bindParam(':id', $id, PDO::PARAM_INT);
        $oPDOStatement->execute();

        $camera = $oPDOStatement->fetch(PDO::FETCH_ASSOC);
        return $camera;
    }

    // Pour ajouter
    public function addCamera($camera) {
        global $oPDO;
        $oPDOStatement = $oPDO->prepare(
            'INSERT INTO camera SET brand=:brand, storage=:storage, price=:price'
        );
        $oPDOStatement->bindParam(':brand', $camera['brand'], PDO::PARAM_STR);
        $oPDOStatement->bindParam(':storage', $camera['storage'], PDO::PARAM_STR);
        $oPDOStatement->bindParam(':price', $camera['price'], PDO::PARAM_STR);

        $oPDOStatement->execute();

        if ($oPDOStatement->rowCount() <= 0) {
            return false;
        }
        return $oPDO->lastInsertId();
    }

    public function updateCameraById($id, $data) {
        $camera = $this->getCamera($id);
        if ($camera) {
            global $oPDO;
            $oPDOStatement = $oPDO->prepare(
                'UPDATE camera SET brand=:brand, storage=:storage, price=:price WHERE id=:id'
            );
            $oPDOStatement->bindParam(':id', $id, PDO::PARAM_INT);
            $oPDOStatement->bindParam(':brand', $data['brand'], PDO::PARAM_STR);
            $oPDOStatement->bindParam(':storage', $data['storage'], PDO::PARAM_STR);
            $oPDOStatement->bindParam(':price', $data['price'], PDO::PARAM_STR);
            $oPDOStatement->execute();
            $camera = $oPDOStatement->fetch(PDO::FETCH_ASSOC);
            return $camera;
        }
    }

    // Pour supprimer
    public function deleteCamera($id) {
        $camera = $this->getCamera($id);
        if ($camera) {
            global $oPDO;
            $oPDOStatement = $oPDO->prepare("DELETE FROM camera WHERE id = :id");
            $oPDOStatement->bindParam(':id', $id, PDO::PARAM_INT);
            $oPDOStatement->execute();
            return "The camera with ID " . $camera['id'] . " has been deleted.";
        } else {
            return "Camera not found.";
        }
    }
    
    public function getCamerasByStockage($stockage) {
        global $oPDO;
        $oPDOStatement = $oPDO->prepare("SELECT id, brand, storage, price FROM camera WHERE storage = :storage ORDER BY storage ASC");
        $oPDOStatement->bindParam(':storage', $stockage, PDO::PARAM_STR);
        $oPDOStatement->execute();
        $cameras = $oPDOStatement->fetchAll(PDO::FETCH_ASSOC);
        return $cameras;
    }
}
?>
