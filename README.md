Cloud Developer (PHP)
=======

A CMS for coders, build your system directly through the CMS, inception style!

 
:: Quick Overview ::
---

![](https://cherone.co.uk/files/screens/cloud-developer/59974ca26e529807929822.gif "")


:: Installing ::
---

Have a database setup first, you dont need to import anything.

Then run the following composer command to install the project.

`composer create-project lcherone/cloud-developer .`

And then complete the post install setup.

![](http://i.imgur.com/mhlCjeC.gif "")

:: Features ::
----

**Modules**

 - Modules group together pages which make an overall feature.
 - Modules are generated and grouped based upon URL path structure.
 - Each module has a before load which is executed before its pages before-loads, and can be used to initialize models, do checks and set up config variables etc. 

**Pages**

 - Auto-Generate pages based upon the URL structure (much like a wiki), then fill in the blanks.
 - Build pages directly using PHP code with full access to the underlying framework (FatFree Framework) and your composer libraries.
 - See the flow of the request and easy access of whats being loaded whilst editing pages.
 - Each page can have its own template.
 - Pages contain a before load section, which can be used to handle POST callbacks or anything which you want to happen before rendering.
 - Apart from the obvious body section, each page also has a CSS and a JavaScript section which allows you to abstract out any inline JavaScript or CSS.
 - **Live Preview** whilst editing if you have the page open in a separate window.

**Menu**

 - Menu links can be used in your templates for umm links.
 - Menu links also have visibility and ordering.

**Objects**

 - Objects are global code blocks or configs which you want to make available to all your modules and pages. This allows you further organise your code and make it reusable.
 - Objects are initialized before the modules before load action is called.
 - You can also set the load/invoke order by priority.

**Snippets**

 - Snippets allow you to create sections of code, which you can easily add to your page simply by clicking a button. Saves time for that repetitive stuff. 
 - Types are (Before Load, Body, JavaScript, CSS and Template).
 - Snippet buttons are then shown next to each editor for easy selection.

**Templates**

 - Templates are the final view before outputting, so it's the main HTML document wrapper around your body content, which has its HTML head section and the loading of assets, general layout and menu links.
 - File manager type direct access to the template.php files and the themes assets organised in a simple folder structure.
 - Standard URLs across templates, `/css/styles.css`, regardless of how many templates you make.
 - Easily clone a template.
 - **Live Preview** (links disabled), which shows overall style and body section.

**Tasks** 

 - Tasks allow you to run snippets of code (PHP or BASH) once or at per second intervals.
 - Define task parameter keys, then on running the task, you can define the values. (todo)
 - Composer task to build composer.json on change.
 - System information task, which collects system metrics for the dashboard.

**Settings**

 - Set the site name and toggle the auto-generated page feature. 
 - Directly manage the `composer.json` file with automatic composer updates which are run by a task.
 - Database backups and restore (On request and by cron job).

---

:: Not working? ::
---

Try debugging it first then open an issue. I am 100% sure it won't work on Windows or < PHP 5.6, not tested on anything other then Ubuntu 17.04 in a LXC container. Let me know how you get on!


:: Cron tasks ::
---

2 cron tasks should be added by the setup, there to drive the task agent, and to do backups:

```
*/5 * * * * cd /var/www/html/bin && bash backup.sh
* * * * * cd /var/www/html/tasks && php run.php >> /dev/null 2>&1
```

:: Security ::
---

The code you write is executed with `eval()`.. so it's up to you to write secure code. 
Else it is executed as `www-data` and can do what it likes! Kinda the idea ;p

Keep in mind, which ever user you add the above crontab will execute task code! So again write secure code. 
But also feel free to run it as root and be able to create a task which you can reboot the server or 
clear memory caches or swap space.

**It's experimental, have Fun & Happy coding!**
