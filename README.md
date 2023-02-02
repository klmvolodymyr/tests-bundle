# Symfony Functional Test

## Installations
Add to composer.json:
````
"require-dev": {
    "volodymyr-klymniuk/sf-functional-test": "dev-master"
},
````
or if you run composer install without dev, but you must run phpunit to section "required"

## Load environment variables from files
Add to your phpunit.xml listener and configure arguments(relative file paths from your phpunit.xml configuration file):
````XML 
<listener class="TestsBundle\PHPUnit\Listener\EnvLoader">
    <arguments>
        <array>
            <element key="0">
                <string>../.env</string>
            </element>
            <element key="1">
                <string>.env</string>
            </element>
        </array>
    </arguments>
</listener>
````

## Load Doctrine fixtures before test cases
Add to your phpunit.xml Listener:
````    
<listeners>
    <listener class="TestsBundle\PHPUnit\Listener\FixtureLoader" />
    <arguments>
        <array>
            <element key="--fixtures">
                <string>%kernel.root_dir%/../tests/DataFixtures</string>
            </element>
        </array>
    </arguments>
</listeners>
````

## Run Doctrine migrations before test cases
Add to your phpunit.xml Listener:
````    
<listener class="TestsBundle\PHPUnit\Listener\MigrationLauncher">
</listener>
````

## Using Test case additional functionallity TestsBundle\TestCase\AppTestCase
### Using Authorization:
1) Add to your config_test.yml:
````     
security:
    firewalls:
        your_secured_category:
            http_basic: ~
````
2)  Use on TestCase
````    
$client = $this->getAuthorizedClient('user_login', 'password');
````

### Work with Symfony DI Container
````
protected function getContainer()
protected function getRouter()
protected function generateUrl($route, $params = [], $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
protected function getSecurityToken()
```` 

### Work with Doctrine
1. Get doctrine service(return $this->container->get('doctrine')):
````
$this->getDoctrine()
````  
2. Find Entity helper method:
````    
protected function findTestEntity($entityClass, $orderBy = 'id', $findBy = [])
````

3. Refresh Entity:
````
protected function refreshEntity($entity) 
````

## Example of correct project structure:
See correct project structure and configs for functional tests on [link](/examples/project-structure/)