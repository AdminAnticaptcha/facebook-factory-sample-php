# Facebook Likes Factory example

This is set of scripts for a Anti-Captcha Factory Demonstration Server. It is built without database dependencies. Use these scripts as an example to understand how everything words and code your own Factory methods.

## Step by step instruction to launch your demo factory

1. Upload these scripts on your server, chmod text files to 755 for scripts access.
2. Register at <a href="https://kolotibablo.com/workers/">Kolotibablo.com</a> as an employee and write down your login and password. At the start page disable "Image Captcha Solving" tasks.
3. Register at <a href="https://anti-captcha.com/clients/">Anti-Captcha.com</a> website, put some funds, go to API settings, grab your client API key, save it.
4. Go to "My Factories" section in the menu.
5. Click "Debugging Employees" button and add credentials for employee account from step #1. You will need this to test your factory tasks at Kolotibablo.com
6. Now create new Factory: enter name, description and other info. In the API section:
 <br>- Write down your factory code. This code is created automatically and is based on the Factory name.
 <br>- Generate a secret access key, write it down.
 <br>- Enter path to these scripts on your server
 <br>- Enter extension ".php"
 <br>- In section "Task data structure" add 2 fields with names "url" and "action" with type "String". Mark both fields as required.
7. Save your new Factory. Your new factory is now visible only to you at both Anti-Captcha and Kolotibablo, as all new Factories are sandboxed at first.
8. Now you have 3 important settings: your client API key, secret key and Factory Code. Visit manage.php at your server and save these setting at the bottom of the page.
9. Go to Factories Directory and find your new Factory. Place order for several tasks (5 for example).
10. Visit manage.php and refresh your tasks list. New tasks must have been added there. If they did not, check your access permissions and scripts path if Factory settings. If problem persists, refer to section Debug in this manual.
11. Visit <a href="https://kolotibablo.com/workers/factory/directory">Factories directory</a> at Kolotibablo.com and find your new Factory. Subscribe to it and return to manage.php. At the employees section you will see you new employee account.
12. Now you can assign one of your tasks to your employee in manage.php. After this, return to Kolotibablo, go to <a href="https://kolotibablo.com/workers/start">start page</a>, make sure your Factory is present in jobs list and click "work via Web" button at the top.
13. If everything is set correctly, you will receive your task immediately. Play with it, paste a confirmation screenshot and finish the task.
14. To confirm that the task is complete, you can review your task in manage.php or at Factories orders section at Anti-Captcha



### Installing

Simply upload all the scripts in public folder with php scripts enabled. Chmod text files to read+write mode.

```
chmod 755 *.txt
```

### Debug

If your scripts are not working at your server for some reason, or platform does not "see" them, use debugging tool located at "My Factories" section.
With this tool you can call all Factory Server API methods and see your server responses.
 
### Documentation
Documentation for Platform API and Factory Server API is available here: 
https://anticaptcha.atlassian.net/wiki/display/API/Factories+API
 
### More help
If you don't understand something or if you have any comments on this tutorial and script set, please contact me via <a href="https://anti-captcha.com/clients/help/tickets/list/all">tickets</a>. Thanks.