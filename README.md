# Composer Rm Plugin

This Composer plugin removes vendor files/directories on install/update.

This is useful when packages add "cruft" that you do not need.
My use case is Intellij picks up these files when I'm inspecting, searching, etc.
Specifically says there are duplicate class definitions, very annoying.
With this plugin, I just add those annoying paths to my global composer config file
and they are removed after every install/update for all of my local projects, beautiful!

# Installation

Require it:
```bash
$ composer global require full/composer-rm-plugin
```

Open your global composer config, which can be found here:
```bash
$ echo $(composer config --global data-dir)/config.json
```

Or just to open it in your default editor:
```bash
$ composer config --global --editor
```

Then add your paths to remove (paths are relative to vendor directory):
```json
{
    "config": {
        "rm-paths": [
            "phpunit/phpunit/build",
            "twig/twig/test/bootstrap.php"
        ]
    }
}
```
Paths do not have to exist, so if PHPUnit or Twig are not installed then they are just skipped.
