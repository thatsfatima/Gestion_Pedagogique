<?php
namespace Apps\Core\Validators;

class Validator {
    public string $nom;
    public string $prenom;
    public string $telephone;
    public string $email;
    public string $photo;

    public function __construct(string $nom, string $prenom, string $telephone, string $email, string $photo) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->telephone = $telephone;
        $this->email = $email;
        $this->photo = $photo;
    }

    public function isEmpty($param, $field) {
        if (empty($param)) {
            return "Le champ ".$field." est obligatoire.";
        }
        return "";
    }

    public function isTel() {
        if (!preg_match("/^70|77|78|76\/0-9$/", $this->telephone)) {
            return "Le numéro de téléphone doit commencer par 70, 77, 78 ou 76.";
        }
        if (!preg_match("/^[0-9]{9}$/", $this->telephone)) {
            return "Le numéro de téléphone doit être de 9 chiffres.";
        }
        return "";
    }

    public function isMail() {
        $regexMail = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        if (!preg_match($regexMail, $this->email)) {
            return "L'adresse email n'est pas valide.";
        }
        return "";
    }

    public function Validate() {
        $errors = [];
        $errors['nom'] = $this->isEmpty($this->nom, "Nom");
        $errors['prenom'] = $this->isEmpty($this->prenom, "Prenom");
        $errors['photo'] = $this->isEmpty($this->photo, "Photo");
        $errors['telephone'] = $this->isEmpty($this->telephone, "Téléphone");
        $errors['email'] = $this->isEmpty($this->email, "Email");
        $errors['telephone2'] = $this->isTel();
        $errors['email2'] = $this->isMail();

        $isEmpty = false;
        foreach ($errors as $error) {
            if (!empty($error)) {
                $isEmpty = true;
            }
        }
        if (!$isEmpty) {
            return [];
        }
        return $errors;

    }
}

?>