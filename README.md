Leo Slack
=========

Leo Slack is framework and solution for service of posting big smilies (also known as stickers) to channels, groups and private chats of your team's slack.

You can read about this project in Russian at [dclg.net](http://dclg.net/2015/10/30/leo-slack/).

How does it look like
---------------------------

The user case is pretty simple. You can type [slash-command](https://api.slack.com/slash-commands) with pre-configured keyword (default is ```/leo```) and code of sticker in slack chat. The service will post an image attachment to the chat.

![](http://dclg.net/wp-content/uploads/2015/10/leoslackHowitlookslike.png) 

Copyright
-------------

This codebase is free for non-commercial usage. Images in /images/source folder are property of "Lingualeo LLC" and can be used only in specified way as stickers for slack chat. Any other way of usage of this images must be approved by Lingual LLC in written form.

Installation
--------------

Leo slack application requires web server powered by php (version >= 5.4). Installation consist of two simple steps:

1. Clone the repository:
```
git clone git@github.com:obukhov/leoslack.git
```
2. Install dependencies with composer:
```
composer install
```

If you haven't composer installed, you can refer to it's [official website](https://getcomposer.org/).

Configuration and setting up
----------------------------

To make things work you must configure following integrations in your slack account.

### Create configuration file

First of all you should copy distributed configuration file to your custom location:

```
cp config.dist.php config.php
```

In this file you can redefine any of settings declared in ```baseConfig.php``` file.

### Configuring slash command

Go to your slack account management panel and add new slash command:

![](http://dclg.net/wp-content/uploads/2015/10/screenshot3.png)

*Command* is a keyword to trigger service integration. This setting must be the same as  ```$config['app']['stickerCommand']``` config value.

*URL* is location of your app installation.

*Token* is an integration token. You must copy token value to  ```$config['slack']['slashCommandToken']``` in your ```config.php``` file.

You should also configure **Autocomplete help text** to make this function more intuitive.

### Configuring incoming web hook

To make posting to slack chat available you must configure [incoming  web hook](https://api.slack.com/incoming-webhooks):

![](http://dclg.net/wp-content/uploads/2015/10/leoslackIncomingWebHook.png)

You can choose any *channel for posting to*, the channel will be overridden to the current one while posting.
 
You must copy *web hook URL* to ```$config['slack']['incomingWebHookURL']``` to make this integration work.

### Add API token

The last integration is [web API](https://api.slack.com/web). It is required for fetching user's name and avatar. You must copy web API token from here: [https://api.slack.com/web](https://api.slack.com/web) to  ```$config['slack']['webApiToken']```  in your ```config.php``` file.

### Configuration overview

There are some useful configuration options declared in ```baseConfig.php```. You can override them in ```config.php``` file.

#### Image processing settings

```
...
'image' => [
        'basePath' => realpath('./images/'),
        'baseUrl' => '', // base url for images, you should redefine it in config.php
        'size' => 250,
        'map' => []
]        
...
```

- **basePath** - you can redefine it if you want to store images in different directory.
- **baseUrl** - is prefix for stickers url when posting it to chat. You must specify domain name and path to leoslack installation.
- **size** - image height. All stickers will be resized to this height.
- **map** - associative array of sticker code and file name.

#### Application settings

```
...
'app' => [
	'helpUrl' => '', // url to index.php file of this project, you should redefine it in config.php
	'stickerCommand' => '/leo',
]
...
```

- ***stickerCommand*** - you can use your own. The only thing you should care is this config value corresponds you slash command configuration.
- ***helpUrl*** - this url is the same as slash command URL, it will show all stickers directory if requested by GET method. It will be shown in error message for user if he tries to use not existing sticker code:

![](http://dclg.net/wp-content/uploads/2015/10/leoslackHelp.png)
