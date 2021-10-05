<?php 

namespace Controllers;

use DAO\CompanyDAO as CompanyDAO;
use Models\Company as Company;

class CompanyController
{
    private $companyDAO;

    public function __construct()
    {
        $this->companyDAO = new CompanyDAO;
    }

    public function ShowAddView()
    {
        require_once (VIEWS_PATH."company-add.php");
    }

    public function ShowEditView($Edit)
    {
        $company = $this->companyDAO->Edit($Edit);
        require_once (VIEWS_PATH."company-edit.php");
    }

    public function ShowListView($name = null, $city = null, $category = null)
    {
        $companyList = $this->companyDAO->getAll();
        
        require_once (VIEWS_PATH."company-list.php");
    }

    public function ShowAdminView($name = null, $city = null, $category = null)
    {
        $companyList = $this->companyDAO->getAll();

        require_once (VIEWS_PATH."admin-home.php");
    }

    public function Add($name, $city, $category)
    {
        $company = new Company();
        $company->setIdCompany(count($this->companyDAO->GetAll())+1);
        $company->setName($name);
        $company->setCity($city);
        $company->setCategory($category);

        $this->companyDAO->Add($company);

        $this->ShowAddView();
    }

    public function Edit ($idCompany, $name, $city, $category)
    {
        $newList = $this->companyDAO->GetAll();

        foreach($newList as $company)
        {
            if($company->getIdCompany() == $idCompany)
            {
                $company->setName($name);
                $company->setCity($city);
                $company->setCategory($category);
            }
        }

        $this->companyDAO->saveAll($newList);
        $this->ShowAdminView();
    }

    public function Action($Remove = "", $Edit = "")
    {
        if ($Edit != "")
        {
            $this->ShowEditView($Edit);
        } else if($Remove != "")
        {
            $this->companyDAO->Remove($Remove);
            $this->ShowListView();
        }
    }
}

?>