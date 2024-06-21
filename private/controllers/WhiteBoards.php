<?php
// Login Controller
require_once('assets/miro/vendor/autoload.php');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class WhiteBoards extends Controller
{

    private $apiKey = WHITEBOARD_API_KEY;
    function index()
    {

        $errors = array();
        $boardDB = new WhiteBoard();

        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['delete-board'])){

                if($boardDB->delete($_POST["boardID"], "fk_board_code") !== null){
                    $this->deleteBoard($this->apiKey, $_POST["boardID"]);
                }

                exit();
            }
        }

        // TO DELETE ALL CREATED BOARDS FROM API
        // foreach ($this->getAllBoards($this->apiKey) as $key => $value) {
        //     $this->deleteBoard($this->apiKey, $value->Id);
        //     // echo "<br>";echo "<br>";echo "<br>";
        //     // print_r($value->Id);echo "<br>";echo "<br>";echo "<br>";
        // }


        $boardRows = $boardDB->where('fk_user_id', Auth::getId());

        // Define the API endpoint and the secret key
        $apiUrl = "https://www.whiteboard.team/api/v1/boards";
        $this->apiKey;
        // GOT ALL saved board codes from DATABASE, and then filter the data gived from API request
        // to create an array, with datas about the boards belongs to the loged in user
        $dbBoardsIds = array();
        $dbBoardsIds = array_map(function($obj){
             return $obj->fk_board_code;
        },$boardRows);

        $APIBoards = $this->getAllBoards($this->apiKey);
        $boardsArr=array();
        foreach ($APIBoards as $key => $value) {
            if(in_array($value->Id, $dbBoardsIds)){
                array_push($boardsArr, $value);
            }
        }
        $this->view("white-boards", [
            'errors' => $errors,
            'boardsArr' => $boardsArr,
            'boardDB' => $boardDB
        ]);
    }

    function single($slug)
    {
        $errors = array();
        if(!isset($slug)){
            new Toast("The board doesn't exist!");
            $this->redirect('whiteBoards');
        }

        $board = new WhiteBoard();
        $boards = $board->where('fk_board_code', $slug);

        if($boards === null){
            new Toast("The board doesn't exist!");
            $this->redirect('whiteBoards');
        }

        // Define the API endpoint and the secret key
        $apiUrl = "https://www.whiteboard.team/api/v1/boards";
        $this->apiKey;

        $this->view("white-board", [
            'errors' => $errors,
            'board_code' => $slug,
            'client_id' => BOARD_CLIENT_ID
        ]);
    }

    function create()
    {
        $errors = array();
        $board_code = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
            if (isset($_POST['creat-board'])) {
                $board = new WhiteBoard();

                if ($board->validate($_POST)) {

                    $this->apiKey;
                    // $newBoardId = 'NEW_BOARD_code';
                    $boardName = $_POST['title'];
                    $members = [
                        ['id' => BOARD_CLIENT_ID, 'role' => 'Facilitator']
                    ];

                    // Create a new Guzzle HTTP client
                    $client = new Client();
                    try {
                        // Send a POST request to the API
                        $response = $client->post('https://www.whiteboard.team/api/v2/boards', [
                            'headers' => [
                                'Api-Key' => $this->apiKey,
                                'Content-Type' => 'application/json'
                            ],
                            'json' => [
                                // 'newId' => $newBoardId,
                                'name' => $boardName,
                                'members' =>  $members
                            ]
                        ]);

                        // Get the response body and decode it
                        $responseData = json_decode($response->getBody(), true);
                        $board_id = $responseData['id'];
                        print_r($responseData);

                        $APIBoards = $this->getAllBoards($this->apiKey);

                        foreach ($APIBoards as $key => $value) {
                            if($value->Code == $board_id)
                            $board_code = $value->Id;
                        }

                        $board->insert([
                            "fk_user_id" => Auth::getId(),
                            "fk_board_code" => $board_code,
                            "board_name" => $boardName
                        ]);
                        new Toast("Board created successfully");
                        $this->redirect("whiteBoards");
                        exit();
                    } catch (RequestException $e) {
                        new Toast('Error');
                        echo 'Error: ' . $e->getMessage();
                        if ($e->hasResponse()) {
                            echo 'Response: ' . $e->getResponse()->getBody()->getContents();
                        }
                    }
                } else {
                    // errors
                    $errors = $board->errors;
                    new Toast("Correct your mistakes and try again.");
                }
            }

        $this->view("white-board-create", [
            'errors' => $errors,
            'board_code' => $board_code,
            'client_id' => BOARD_CLIENT_ID
        ]);
    }

    private function getAllBoards($apiKey)
    {
        // Define the API endpoint
        $apiUrl = "https://www.whiteboard.team/api/v1/boards";

        return $this->apiRequest($apiKey, $apiUrl, 'GET');
    }

    private function getBoard($apiKey, $boardID)
    {
        // Define the API endpoint
        $apiUrl = "https://www.whiteboard.team/api/v1/boards/" . $boardID;

        return $this->apiRequest($apiKey, $apiUrl, 'GET');
    }

    private function deleteBoard($apiKey, $boardID)
    {
        // Define the API endpoint
        $apiUrl = "https://www.whiteboard.team/api/v1/boards/" . $boardID;

        return $this->apiRequest($apiKey, $apiUrl, 'DELETE');
    }

    private function apiRequest($apiKey, $apiUrl, $method)
    {
        // Initialize a cURL session
        $ch = curl_init();

        // Set the URL
        curl_setopt($ch, CURLOPT_URL, $apiUrl);

        // Set the HTTP header with the API key
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Api-Key: $apiKey"
        ));

        // Set the method to GET
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        // Return the response instead of printing it
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the request
        $response = curl_exec($ch);
        // Check for errors
        if (curl_errno($ch)) {
            echo 'Request Error:' . curl_error($ch);
            //  $response = null; // In case of error, set response to null
        } else {
            // Parse the response if needed
            $response = json_decode($this->csvToJson($response));
        }
        // Close the cURL session
        curl_close($ch);
        return $response;
    }

    private function csvToJson($csvString)
    {
        // Split the CSV string into lines
        $lines = explode("\n", $csvString);

        // Get the headers
        $headers = str_getcsv(array_shift($lines));

        $data = array();

        // Parse each line
        foreach ($lines as $line) {
            if (trim($line) === '') continue; // Skip empty lines

            // Parse the CSV line into an array
            $row = str_getcsv($line);

            // Combine the headers and row data into an associative array
            $data[] = array_combine($headers, $row);
        }

        // Convert the array to JSON
        return json_encode($data, JSON_PRETTY_PRINT);
    }
}
