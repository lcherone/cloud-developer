Cloud Developer (PHP)
=======

WIP!

**Ever asked yourself the following?**

 - Why do I need to hardcode my codebase?
 - I'm from the matrix, why cant I directly build the project though the project?
 - Why are routing, controllers, models and views not dynamically created during development?
 - Why do I waste so much time with the fundamentals of the base system or framework?
 - Why is there not a "framework" level CMS?

Well this little project aims to solve a few of them issues.

Features
----

**Pages**

 - Build pages directly using PHP code, which has full access to the underlying framework (FatFree Framework) and any objects or code which you create.
 - Each page contains a before load section which can be used to handle POST callbacks or anything which you want to happen before rendering the view if you render the view at all! Maybe you need json/xml or what not!
 - Each page also contains a JavaScript section which allows you to abstract out any inline JavaScript which has cheeped into your views with better placement and invoking of it.

**Modules**

 - Modules group together pages which make a feature, each module has a beforeload which is executed before its pages and can be used to initialise models, do checks or set up a global configs ect. 
 - Modules are automatically generated and grouped based upon URL structure.

**Menu**

 - Create menu links which can be used in your templates menu code. Not generally required if you integrate your own menus.

**Objects**

 - Objects are PHP classes or variables, which you make available to all your pages code, all objects are initialised before the `beforeload` action is called. This allows you organise your code and make it reusable.

**Snippets**

 - Snippets allow you to create sections of code, which you can easily add to your page simply by clicking a button, which will save time for repetitive stuff. Snippets buttons are then shown next to each editor for easy selection.

**Template**

 - Templates are the final view before outputting, so its the main wrapper around your body content, which has its HTML head section and the loading of assets, general layout and menu links.

**Settings**

 - Settings includes setting the site name and toggling the auto-generate page feature. 
 - Within the settings you can also change the `composer.json` file. You still need to run commands on host though it gives an overview of whats available to use within the page code.

 
Screens:
---

{X}


Installing:
---

If your brave enough to want to try, then run the following composer command to install the project.

{COMPOSER PROJECT COMMAND}

Database ect.
---

Edit `./app/config.ini` to match your database. Make sure you have a database created first, then visit the script in your browser to complete the setup.

If it dont work!
---

Try debugging it and then if its not your code, open an issue. I am pretty sure it wont work with < PHP 5.6 or on windows, not tested on mac.. let me know how you get on.

Cron tasks
---

To keep it simple and slim, you only have one version of your code base within the database, so backing it up is wise. There is a bash script which will dump your database as every 5 mins backup and one every day. Use it!

*/5 * * * * cd /var/www/html/bin && bash backup.sh


Security
---

The code you write is executed with `eval()`.. so its upto you to write secure code. 
Else it is executed as `www-data` and can do what it likes! Kinda the idea ;p

Keep in mind tasks code is run as root! So again write secure code.
The system has not been fully security audited so use at your own risk, it expremental!


Requirements
--

Need `wkhtmltopdf` to generate template previews, were using the `knplabs/knp-snappy` package.

`sudo apt-get install wkhtmltopdf libfontconfig1 libxrender1 -y`
