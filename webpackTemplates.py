import shutil, os, sys, subprocess

class bcolors:
    OKBLUE = '\033[94m'
    OKGREEN = '\033[92m'
    WARNING = '\033[93m'
    FAIL = '\033[91m'
    ENDC = '\033[0m'

class configs:
    ACTIVE_DIR_PATH=r'./resources/views/active'
    TEMPLATE_ROOT=r'./storage/repo/templates'



def create_dir_backup(dir, bkp_dir):
    if os.path.isdir(bkp_dir):
        print (bcolors.FAIL + "ERROR: Active directory back up already exists. Remove " + bkp_dir + " to continue." + bcolors.ENDC)
        sys.exit(1)
    else:
        os.makedirs(bkp_dir)
        for file in os.listdir(dir):
            shutil.copy(os.path.join(dir, file), bkp_dir)



def create_mix_config_backups ():
    shutil.copyfile('./webpack.mix.js', './webpack.mix.js.bkp')
    shutil.copyfile('./webpack-templates.mix.js', './webpack-templates.mix.js.bkp')



def activate_mix_file_for_templates():
    os.remove('./webpack.mix.js')
    os.rename('./webpack-templates.mix.js', './webpack.mix.js')



def restore_mix_config_backups():
    if os.path.isfile('./webpack.mix.js'):
        os.remove('./webpack.mix.js')
    if os.path.isfile('./webpack-templates.mix.js'):
        os.remove('./webpack-templates.mix.js')
    os.rename('./webpack.mix.js.bkp', './webpack.mix.js')
    os.rename('./webpack-templates.mix.js.bkp', './webpack-templates.mix.js')



def restore_dir_backup (bkp_dir, dir):
    # delete existing dir
    shutil.rmtree (dir)
    # move bak to actual dir
    shutil.move(bkp_dir, dir)



def replace_in_place(file, pattern, replacement):
    with open(file) as f:
        contents = f.read()
        new_contents = contents.replace(pattern, replacement)
    with open(file, "w") as f:
        f.write(new_contents)



def replace_active_template_color_var (color):
    for file in os.listdir(configs.ACTIVE_DIR_PATH):
            filePath = os.path.join(configs.ACTIVE_DIR_PATH, file)
            if file.endswith('.php') and os.path.isfile(filePath):
                #print('Replacing primary color with [' + color + '] for: ' + file)
                replace_in_place(filePath, '{{$data->ref->template->primaryColor}}', color)



def clear_active_directory():
    for file in os.listdir(configs.ACTIVE_DIR_PATH):
        os.remove(os.path.join(configs.ACTIVE_DIR_PATH, file))



def load_active_dir_from (templateDir):
    for file in os.listdir(templateDir):
        shutil.copyfile (os.path.join(templateDir, file), os.path.join(configs.ACTIVE_DIR_PATH, file))



def run_npm_build (env):
    try:
        print('Running npm...')
        results = subprocess.run('npm run --silent ' +  env, shell=True, check=True)
        # print(results.stdout)
        return results
    except BaseException as error:
        print(bcolors.FAIL + 'An exception occurred: {}'.format(error) + bcolors.ENDC)



def generate_styles_for_color(color):
    replace_active_template_color_var(color)
    run_npm_build('prod')



def post_process_transpiled_scripts(templateDir, color):
    # only rename the script
    css_file_name = os.path.basename(templateDir).replace(" ", ".").replace('-', '.').replace('_', '.').lower() + "." + color + ".css"
    print(bcolors.OKGREEN + '[*] Renaming the style.css file to ' + bcolors.OKBLUE + css_file_name + bcolors.ENDC)
    shutil.copyfile('./public/css/style.css', './public/css/' + css_file_name)




def generate_styles_for_template(templateDir):
    for color in ['blue', 'gray', 'green', 'indigo', 'orange', 'pink', 'purple', 'red', 'teal', 'yellow']:
        clear_active_directory()
        load_active_dir_from (templateDir)
        print(bcolors.OKGREEN +'[*] Transpiling scripts present in [' + bcolors.OKBLUE + templateDir +bcolors.OKGREEN + ']. Processing color = ' + bcolors.OKBLUE + color + bcolors.ENDC)
        generate_styles_for_color(color)
        post_process_transpiled_scripts(templateDir, color)




### Begin Here ####

def main():

    #
    # Before doing anything, let's first create backups for the
    # contents of the active directory and webpack mix files.
    # We will restore the backups at the end.
    #
    print(bcolors.OKGREEN + '[*] Creating a backup of active directory.' + bcolors.ENDC)
    create_dir_backup('./resources/views/active', './resources/views/active_dir_bkp')

    print(bcolors.OKGREEN + '[*] Creating a backup of webpack.mix.js file.' + bcolors.ENDC)
    create_mix_config_backups()


    #
    # While genrating css files for various templates, we do not
    # need to use the original webpack.mix.js file as that contains
    # mix functionalities for both backend and frontend js and css.
    #
    # We have a separate mix file - only targetted for the template
    # css files, so we will temporarily use this mix config file.
    #
    activate_mix_file_for_templates()



    for template in os.listdir(configs.TEMPLATE_ROOT):
        templateDirectory = os.path.join(configs.TEMPLATE_ROOT, template)
        if os.path.isdir(templateDirectory):
            # For each template perform the following operation
            print(bcolors.OKGREEN + '[*] Processing Template ' + bcolors.OKBLUE + template + bcolors.ENDC)
            generate_styles_for_template (templateDirectory)

    #
    # Restore all the old active dir files as well as original
    # mix config files.
    #
    print(bcolors.OKGREEN + '[*] Restoring the Active directory contents from the backup.' + bcolors.ENDC)
    restore_dir_backup('./resources/views/active_dir_bkp', './resources/views/active')
    print(bcolors.OKGREEN + '[*] Restoring the mix config files from the backup.' + bcolors.ENDC)
    restore_mix_config_backups()




if __name__ == "__main__":
    main()
