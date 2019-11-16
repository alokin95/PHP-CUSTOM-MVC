_Welcome to the PHP-CUSTOM-MVC wiki!_

This project simulates an MVC pattern written in PHP.

# Configuration  
Rename the `.env.example` to .`env` and populate it.   

# Error handling  
Based on the `APP_ENV` variable that is set in the `.env` file, it will either show the error page (for the local environment), or it will log the errors with minimal response to the user (every other environment).

# Container (Lazy loading)  
Container class (singleton) is used to register all the services. It has a `get($service)` method that will instantiate a service and for every subsequent call to the `get($service)` method with the same service as a parameter in a single request will reference the already instantiated service.

# Routing
Routing is done in the **public/routes.php** file. The two available methods are `GET` and `POST`. Routing takes 3 parameters, with first being the URI, second a controller, and third a controller action.
### Example
    HTTP GET to www.domain.com, FrontController->indexAction()
    $router->get('/', 'FrontController', 'index');

    HTTP POST to www.domain.com/login, AuthController->loginAction()
    $router->post('login', 'AuthController', 'login'); 
# Controllers
Every controller class should extend **src/Controllers/Controller.php** class.  
Every controller action should have a suffix **Action**. For example: **indexAction**.  
Container, Repository, and Response classes are injected in every controller using _Reflection_. 
 
### Controller example:

    class PostController extends Controller
    {
        public function __construct()
        {
            $this->middleware(['logged.check']);
        }

        public function indexAction()
        {
            $posts = $this->repository->table('posts')->all();
            return $this->response->render('posts/index', compact('posts'));
        }
    }
### Controller response
The _Response_ class is automatically injected into the controller using Reflection. A controller action should return a call to the **render()** method or the **json()** method of the _Response_ class.   
The **render()** method accepts two parameters, with first being the view it will return, and a second parameter is data that will be passed to the view.  
The view parameter is loading a file from the **templates** folder and is adding a **.php** suffix.  
The data parameter should be an associative array.  
**Render example:**

    public function indexAction()
    {   $user['user'] = 'Admin';
        return $this->response->render('posts/index', $user);
    }


**JSON example:  **
The **json()** method accepts two parameters, with first being an array of data and the second being the HTTP response code. This method will change Content-Type to _application/json_ and return the status code you provided (defaut value is 200).

# Repository class  
The _Repository_ class is injected into every controller using Reflection, and it has a couple of methods, with the most important being **table($tableName)**.  
Repository usage example:  

    //Gets all the data from the `posts` table
    $posts = $this->repository->table('posts')->all();  

    //Finds a single entry from the table `posts` by `id` column name. You can specify the custom column name in the second parameter
    $post = $this->repository->table('posts')->findById($post);  

    //Finds a single record in the database using the WHERE clause  
    user = $this->repository->table('users')->findBy(['username' => $username, 'password' => $password]);

# Middleware
If middleware is assigned to a controller, it will be called for every action of that controller.  
Middleware assigning example:  

    public function __construct()
    {
        $this->middleware(['logged.check']);
    }
### Creating a Middleware
Middlewares are stored in the **src/Middleware** directory. Every Middleware should implement the **MiddlewareInterface**.  
Middleware example:  
     
    class CheckIfLoggedInMiddleware implements MiddlewareInterface
    {
         /**
         * Runs on every request.
         */
        public function handle()
        {
            if (!session('user'))
            {
                redirect('/');
            }
        }
    }  
### Registering a middleware  
In order to assign a middleware to a controller, you must first register it in the **src/Providers/MiddlewareProvider**.
Example:  

    class MiddlewareProvider
    {
        private $middlewares = [
          'logged.check' => CheckIfLoggedInMiddleware::class,
        ];
    } 
# Helper methods
in the `src/Common/helpers.php` there are helper methods for setting/unsetting the session, redirecting, reading the `.env` file, getting services from the `Container` etc.
