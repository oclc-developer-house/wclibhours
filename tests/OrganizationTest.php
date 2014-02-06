    set_include_path(get_include_path() . PATH_SEPARATOR . '../lib/');
    set_include_path(get_include_path() . PATH_SEPARATOR . '../vendor/');
    require_once "autoload.php";
    
class OrganizationTest extends PHPUnit_Framework_TestCase
{
  public function testHasAddress()
  {
     
  }

}
