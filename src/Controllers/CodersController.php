<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Coder;
use phpDocumentor\Reflection\Location; // QUE ES ESTO?

class CodersController
{

    public function __construct()
    {
        if (isset($_GET) && isset($_GET["action"]) && ($_GET["action"] == "create")) {
            $this->create();
            return;
        }

        if (isset($_GET) && isset($_GET["action"]) && ($_GET["action"] == "store")) {
            $this->store($_POST);
            return;
        }

        if (isset($_GET) && isset($_GET["action"]) && ($_GET["action"] == "edit")) {
            $this->edit($_GET["id"]);
            return;
        }
        
        if (isset($_GET) && isset($_GET["action"]) && ($_GET["action"] == "update")) {
            $this->update($_POST, $_GET["id"]);
            return;
        }

        if (isset($_GET) && isset($_GET["action"]) && ($_GET["action"] == "delete")) {

            $this->delete($_GET["id"]);
            return;
        }

        $this->index();
       
    }

    public function index(): void
    {
        $studentsList = Coder::all();

        new View("CoderList", [
            "students_db" => $studentsList,
        ]);
    }

    public function create(): void
    {
        new View("CreateCoder");
    }

    public function store(array $request): void
    {
        $newStudent = new Coder($request["name"], $request["subject"]);
        $newStudent->save();

        $this->index();
    }

    public function delete($id)
    {
        $studentToDelete = Coder::findById($id);
        $studentToDelete->delete();

        $this->index();
    }
    
    public function edit($id)
    {
        $studentToEdit = Coder::findById($id);
        new View("EditCoder", ["student" => $studentToEdit]);
    }

    public function update(array $request, $id)
    {
        $studentToUpdate = Coder::findById($id);
        $studentToUpdate->rename($request["name"]);
        $studentToUpdate->editSubject($request["subject"]);
        $studentToUpdate->update();

        $this->index();
    }
}
