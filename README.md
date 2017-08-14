Cloud Developer (PHP)
=======

This fun little weekend project is a "Code" CMS! With it, you can code and build a system directly within it.

::Features::
----

**Pages**

 - Auto-Generate Pages based upon the URL structure (bit like a wiki), then fill in the blanks.
 - Build pages directly using PHP code with full access to the underlying framework (FatFree Framework) and composer libraries.
 - See the flow of the request and easy access of whats being loaded whilst editing pages.
 - Pages contain a before load section, which can be used to handle POST callbacks or anything which you want to happen before rendering.
 - Each page contains also JavaScript section which allows you to abstract out any inline JavaScript. With end-of-document placement.

**Modules**

 - Modules group together pages which make an overall feature,
 - Each module has a before load which is executed before its pages before load and can be used to initialize models, do checks and set up global configs etc. 
 - Modules are automatically generated and grouped based upon URL structure.

**Menu**

 - Menu links can be used in your templates.

**Objects**

 - Objects are global code blocks or configs which you want to make available to all your modules and pages. This allows you further organise your code and make it reusable.
 -  Objects are initialized before the modules before load action is called.
 - You can also set the load/invoke order by priority.

**Snippets**

 - Snippets allow you to create sections of code, which you can easily add to your page simply by clicking a button, which saves time for that repetitive stuff. Snippet buttons are then shown next to each editor for easy selection.

**Templates**

 - Templates are the final view before outputting, so it's the main HTML document wrapper around your body content, which has its HTML head section and the loading of assets, general layout and menu links.
 - Direct access to the template.php files and the themes assets organised in a simple folder structure.
 - Clone a template.

**Tasks** 

 - Tasks allow you to run snippets of code (PHP or BASH) once or at per second intervals.
 - Define task parameter keys, then on running the task, you can define the values. (todo)
 - Composer task to build composer.json on change.
 - System information task, which collects system metrics for the dashboard.

**Settings**

 - Set the site name and toggle the auto-generate page feature. 
 - Directly manage the `composer.json` file with automatic composer updates which are run by a task.
 - Database backups and restore.

 
::Screens::
---

<img src="https://cherone.co.uk/files/screens/cloud-developer/1.png" width="400"><img src="https://cherone.co.uk/files/screens/cloud-developer/2.png" width="400"><img src="https://cherone.co.uk/files/screens/cloud-developer/3.png" width="400"><img src="https://cherone.co.uk/files/screens/cloud-developer/18.png" width="400"><img src="https://cherone.co.uk/files/screens/cloud-developer/5.png" width="800"><img src="https://cherone.co.uk/files/screens/cloud-developer/6.png" width="400"><img src="https://cherone.co.uk/files/screens/cloud-developer/7.png" width="400"><img src="https://cherone.co.uk/files/screens/cloud-developer/8.png" width="400"><img src="https://cherone.co.uk/files/screens/cloud-developer/9.png" width="400"><img src="https://cherone.co.uk/files/screens/cloud-developer/10.png" width="800"><img src="https://cherone.co.uk/files/screens/cloud-developer/12.png" width="800"><img src="https://cherone.co.uk/files/screens/cloud-developer/13.png" width="400"><img src="https://cherone.co.uk/files/screens/cloud-developer/16.png" width="400"><img src="https://cherone.co.uk/files/screens/cloud-developer/14.png" width="400"><img src="https://cherone.co.uk/files/screens/cloud-developer/15.png" width="400"><img src="https://cherone.co.uk/files/screens/cloud-developer/17.png" width="800">

::Installing::
---

If you're brave enough, then run the following composer command to install the project.

`composer create-project lcherone/plinkerui --stability dev`

Then complete the post install setup.

::Database::
---

Make sure you have a database created first, if not you can edit `./app/config.ini` to suit.
You dont need to import anything.


::It dont work!::
---

Try debugging it first then open an issue or PR. I am 100% sure it won't work with < PHP 5.6 or on windows, not tested on mac.. let me know how you get on. Works fine on Ubuntu ;p


::Cron tasks::
---

2 cron tasks should be added by the setup, there to drive the task agent and to backup:

```
*/5 * * * * cd /var/www/html/bin && bash backup.sh
* * * * * cd /var/www/html/tasks && php run.php >> /dev/null 2>&1
```


::Security::
---

The code you write is executed with `eval()`.. so it's up to you to write secure code. 
Else it is executed as `www-data` and can do what it likes! Kinda the idea ;p

Keep in mind, which ever user you add the above crontab will execute task code! So again write secure code. 
But also feel free to run it as root and be able to create a task which you can reboot the server or 
clear memory caches or swap space.

**Its experimental, have Fun & Happy coding!**
