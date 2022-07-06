[Raw Documentation](../docs/doc_en.md)

# WebPress

A easy CMS that uses JSON database and used for all webpage including Domain and Localhosts

### what is this? {#what-is-this}

this is a easy CMS that allows you use User Infrence(UI) and allow easier search up using high qulity SEO information and simple building structures. This uses JSON files to make/create pages onto your webpage. Your pages are built by written codes, which then it is converted to JSON file.

***

### Requirements {#requirements}

###### System requirements
- PHP 7.4 or higher
- Webserver (Apache)
###### PHP extendtions
- PHP [GD](http://php.net/manual/en/book.mbstring.php) module for image processing.
- PHP [JSON](https://php.net/manual/en/book.json.php) module for JSON manipulation.
- PHP [mbstring](http://php.net/manual/en/book.mbstring.php) module for full UTF-8 support.

***

### Basics {#basics}

The basics of these are simple once you access this url `http(s)://{your_domain}/` or `http(s)://{your_domain}/{folder}` there is 2 **HTACCESS** that will have 1 being you main(WebPress) page and the other will be *Your home page* for your website. which will be in it's own independent folder.

***

### How to install? {#how-to-install}

To install, just insert the *Un-ZIPED* the folder to your *HTDocs(Root folder)* to start running the software. Once your done go to `http(s)://{your_domain}/` or add `./{folder}/` to access the main WebPress Page **Recommended: htdocs**. After you are there start by configurate your after you create account _**(This will be default to Admin on the first register, after that you are going to be a member)**_.

***

### Roles: {#roles}

Roles are important, they are very customizable and has 3 main one, *admin, mod, and member* This will make users have different access. 

`admin`, have all control over how people can view and see what changes and notify. Can also have `mod` help edit pages and make thing better. Edit plugin and change themes, etc. Ban users by _name_ or _ip_.

`mod` can help `admin` out by accessing the editor(if allowed by `admin`) to make pages better. They can also report any suspicious activity and the `admin` will recive it.

`member` can only view and use page elements.

check out the [Jobs Document](#jobs) for what you can do with users status.

***

### Error Pages {#error-pages}

You can make custom error pages in the [_dashboard.php/configs_](./configs) and make custom errors so your page can show something, instend of boring old error page.

List of error documents(editable)

1. 400 - Bad request
2. 401 - Auth required
3. 403 - Forbidden
4. 404 - Not Found
5. 500 - Internal Server Error

***

### Jobs {#jobs}

In the form of roles  of moderation. Here is a table that is defaulted to you

| Tag | Target | custom? |
| ---- | ------ | --------- |
| admin| first income | X |
| mod | specified users | X |
| member | registered users | X |

You(`admin`) can remake jobs by going to `dashboard.php/roles/edit?job={jobName}` to edit what this custom job might be

### Editors

The editors this project uses is __BBCode__, __Markdown__, and __WYSIWYG__

### Public vs Private Key

The public key is what you would use for configuration of any plugin that requires that key, 
The Private key is what is used for backup login, which from different location use it to access it.
