<?php

namespace CRDV\Model\AdminFunctions;

use CRDV\Model\UserFunctions\User;
use CRDV\Model\UserFunctions\UserDAO;

date_default_timezone_set("America/Sao_Paulo");
header("Content-Type: application/json");
class Admin implements AdminInterface{

    public function addBanner($image)
    {
        $inputField = "productImage";
        /**
         * Getimagesize() returns false if file
         * is not an image
         */
        if(isset($image) && !empty($image) && getimagesize($image[$inputField]['tmp_name']) != false)
        {
            /**
             * Validate image file extension
             * Image must be GIF, JPEG, JPG or PNG
             */

            
            $fileExtension = strrchr($image[$inputField]['name'], '.');
            
            $validExtensions = array(".gif", ".jpg", ".jpeg", ".png");
            (!in_array($fileExtension, $validExtensions)) ? die(json_encode(array("error" => "Tipo de arquivo não suportado"))) : '';
            

            /**
             * Validate image size
             * blocking xMB+ images
             */
            
            $image[$inputField]['size'] > 3000000 ? die(json_encode(array("error" => "Arquivo muito grande"))) : '';

            /**
             * Hashes image filename using MD5
             * and move file to banner folder
             * e.g. cbc9d8942ea7a05d936ef48f825c51eb.jpg
             */

            $filename = md5($image[$inputField]['tmp_name'].time().rand(0,99)).$fileExtension;
            move_uploaded_file($image[$inputField]['tmp_name'], dirname(__DIR__, 2).'/View/imagens/'.$filename);
            return $filename;

        }
        else
        {
            http_response_code(400);
            die(json_encode(array("error" => "Arquivo de imagem inválido")));
        }
    }

    /**
     * Update user information
     */
    public function updateClient(UserDAO $userDb, User $user)
    {
        $userDb->update($user);
    }

    /**
     * Check for file existence before
     * deleting it, or else returns
     * http code 404
     */

    public function delBanner(String $bannerName)
    {
        if(isset($bannerName) && !empty($bannerName) && file_exists(dirname(__DIR__, 2).'/View/imagens/'.$bannerName))
        {
            unlink(dirname(__DIR__, 2).'/View/imagens'.$bannerName);
            return json_encode(array("ok" => "Imagem deletada com sucesso"));
        }
        else
        {
            die(json_encode(array("error" => "Não foi possível deletar a imagem")));
        }
    }

    public function updateBanner(String $bannerName, $file){
        if(isset($bannerName) && !empty($bannerName) && file_exists(dirname(__DIR__, 2).'/View/imagens/'.$bannerName))
        {
            $newName = $this->addBanner($file);
            if(is_string($newName)){
                unlink(dirname(__DIR__, 2).'/View/imagens/'.$bannerName);
                return $newName;
            } else {
                return false;
            }
        } else {
            die(\json_encode(array("error"=>"Imagem não existe no servidor.")));
        }
    }
}