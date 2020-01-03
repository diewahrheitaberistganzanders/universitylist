# universitylist
PHP Library for listed universities in a country

This is just a simple PHP-external to collect informations of available universities for each country, prior currently only in germany. 
Currently it will result informations about name, city and the start date of the summer- and wintersemester.

It's also extendable for other countries - this is up to you. Create your own branch to boost this project. 
This is up to you - I will follow your work promtly..


## Usage

    use sem4711\Universitylist\Universities;

    try {
        $universities = new Universities('de');
        $universitiesList = $universities->getData();
    }
    catch(Exception $e) {
        $universitiesList = [];
    }
