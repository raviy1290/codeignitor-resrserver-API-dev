# codeignitor-restserver-API-dev
Maintainable API development when using codeignitor-restserver library on codeignitor for api development


While developing API using codeignitor framework (https://codeigniter.com/) restserver library
(https://github.com/chriskacerguis/codeigniter-restserver) is a popular and easy way to develop rapidly.

The APIs endpoints gets ready in a ziffy with minimal configuration (check UserAPI.php for example)
  
  Ex: 
  function user_get($id=null) results into a API endpoint 
  
  http://<server>/index.php/userapi/user/1

and so other function like 
  
    function user_post
    
    function user_put
    
    function user_delete
    

But the problem happens when application gets bigger and you get many use cases of getting ENTITY 

Ex: if you want to get user info plus some mote info attached to user with other entities then the new API becomes something like 
  
    function user_plus_additional_info_get($id=null){
    
    http://<server>/index.php/userapi/user_plus_additional_info/1
    
    and more and more...

It gets difficult to maintain.

Now there are more then one approches to solve it and make it maintanable.

I will add a little approch here only demostrating GET requests, but the same can be extended to POST and other methods.

Here, we will introdude one more base controller to be extended by all controller which has basic ability to handle simple GET call on some entity.

    Ex: http://<server>/user/1 
will return User entity properties for ID=1
  
for more advance calls we can construct URL as 

    http:<server>/userapi2/121/?action={"name":"get_user_plus_additional_linked_data", "args":{"user_id":123}}
    
    Check controller UserAPI2.php and Base_Controller.php for more information.

So now all GET calls for one entities falls into 2 category

    Simple: http:<server>/userapi2/123
  
    Complex: http:<server>/userapi2/121/?action={"name":"get_user_plus_additional_linked_data", "args":{"user_id":123}}
  
Infact all other calls POST, PUT, DELETE, PATCH also falls into these two categories only simple, complex.




