Instructions for Running Locally:

1. Clone the repository.
2. You can run this via php artisan serve or via dedicated server like nginx, apache. (*Running thru php artisan server will require 2 instance in order for the authentication to work)
3. Make sure to enable these php extensions:
   a.curl
   b.fileinfo
   c.mbstring
   d.mysqli
   e.openssl
   f.sodium
   g.zip
4. Run `composer install`
5. Run `php artisan migrate`
6. Run `php artisan passport:install`
7. Generate Client Credentials by running `php artisan passport:client --password`. Use the default options.
8. Save the Client ID and Client Secret generated.


Calling the APIs: I have created a collection via Postman. It can be accessed thru this link `https://www.postman.com/lunar-module-physicist-83864225/workspace/julius-public/request/34599323-0f69afef-6e7b-4953-9cf9-7eca245ab97c`.
API for List/Get/Delete/Create/Update Successful Email has a client middleware which requires you to login first using the Auth API in the collection. Once authenticated, you will be able to call the APIs.

Create API will only require `email` as the parameter as `raw_text` will be generated automatically. This goes the same with the Update API with an additional `id` parameter.
