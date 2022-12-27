La classe FormGenerator permet de créer un formulaire HTML à partir d'un tableau de champs passé en paramètre lors de l'instanciation de l'objet.

Le constructeur de la classe prend en entrée 5 paramètres :

$fields : un tableau contenant la liste des champs du formulaire. Chaque champ est décrit par un tableau associatif qui doit comprendre au minimum la clé type indiquant le type de champ à ajouter (input, select, textarea ou button) et la clé name qui donne le nom du champ. D'autres clés sont possibles pour ajouter d'autres attributs au champ, comme label, css_class, div_wrapper, id, placeholder, required, disabled, etc. Selon le type de champ, d'autres clés peuvent être nécessaires, comme input_type pour les champs input, options pour les champs select, ou value pour les champs button.
$method : la méthode de soumission du formulaire (GET ou POST).
$action : l'URL de destination de la soumission du formulaire.
$enctype : l'attribut enctype du formulaire.
$css_class : la classe CSS à appliquer au formulaire.
La classe FormGenerator possède plusieurs méthodes pour ajouter des champs au formulaire :

addInput : permet d'ajouter un champ input.
addSelect : permet d'ajouter un champ select.
addTextarea : permet d'ajouter un champ textarea.
addButton : permet d'ajouter un bouton.
Chaque méthode prend en entrée plusieurs paramètres qui permettent de configurer le champ à ajouter.

La classe possède également une méthode getForm qui permet de générer le code HTML du formulaire. Cette méthode renvoie une chaîne de caractères contenant le code HTML du formulaire.