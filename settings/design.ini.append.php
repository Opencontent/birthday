#?ini charset="iso-8859-1"?
# eZ publish configuration file for designs
#
# NOTE: It is not recommended to edit this files directly, instead
#       a file in override should be created for setting the
#       values that is required for your site. Either create
#       a file called settings/override/design.ini.append or
#       settings/override/design.ini.append.php for more security
#       in non-virtualhost modes (the .php file may already be present
#       and can be used for this purpose).

[ExtensionSettings]
# A list of extensions which have design data
# It's common to create a settings/design.ini.append file
# in your extension and add the extension name to automatically
# get design from the extension when it's turned on.
DesignExtensions[]=birthday


