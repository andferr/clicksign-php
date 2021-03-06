<?php
require_once(__DIR__ . '/../ClicksignClient.php');
require_once(__DIR__ . '/../ClicksignService.php');
    
class ClicksignDocuments extends ClicksignService
{

    public function all()
    {
        $data = array();
        return $this->client->request("/documents", "GET", $data, 200, "application/json");
    }

    public function find($documentKey)
    {
        $data = array();
        return $this->client->request("/documents/$documentKey", "GET", $data, 200, "application/json");
    }

    public function upload($filePath)
	{
        $data = array("document[archive][original]" => "@$filePath");
        return $this->client->request("/documents", "FILE", $data, 200, "multipart/mixed; boundary=frontier");
	}

    public function download($documentKey)
    {
        return $this->client->getFile("/documents/$documentKey/download");
    }

    public function createList($documentKey, $signers, $message = "", $skipEmail = false)
    {
        $data = array("signers" => $signers, "message" => $message, "skip_email" => $skipEmail);
        $json = json_encode($data);
        return $this->client->request("/documents/$documentKey/list", "POST", $json, 200, "application/json");
    }
    
}
