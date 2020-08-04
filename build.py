import argparse, subprocess, sys, os, shutil
import webpackTemplates

class configs:
    DEFAULT_TEMPLATES = ['Serenity', 'Serenity Dark']
    FE_CSS_FILES = [
        'serenity.blue.css',
        'serenity.gray.css',
        'serenity.green.css',
        'serenity.indigo.css',
        'serenity.orange.css',
        'serenity.pink.css',
        'serenity.purple.css',
        'serenity.red.css',
        'serenity.teal.css',
        'serenity.yellow.css',

        'serenity.dark.blue.css',
        'serenity.dark.gray.css',
        'serenity.dark.green.css',
        'serenity.dark.indigo.css',
        'serenity.dark.orange.css',
        'serenity.dark.pink.css',
        'serenity.dark.purple.css',
        'serenity.dark.red.css',
        'serenity.dark.teal.css',
        'serenity.dark.yellow.css',
    ]
    JS_FILES = [
        'frontend.js',
        'app.js',
        'comments.js',
        'profile.js'
    ]


def main():
    parser = argparse.ArgumentParser()

    parser.add_argument("-a", "--analyze", action="store_true", help="Perform a quick health analysis and show a report.")
    parser.add_argument("-b", "--build",   action="store_true", help="Build frontend or backend stylesheets or JS.")
    parser.add_argument("-u", "--unit",    action="store_true", help="Runs phpunit tests. Stops everything if test fails.")
    parser.add_argument("-c", "--commit",  action="store_true", help="Commit the changes to Github.")
    parser.add_argument("-r", "--reset",   action="store_true", help="Reset the development environment.")

    args = parser.parse_args()



    #
    # Build the templates style sheets and compile
    # both app and template js files.
    #
    if args.build:
        build_template_stylesheets()
        build_app_stylesheets_and_all_scripts()



    #
    # Reset the entire environment
    #
    if args.reset:
        print(webpackTemplates.bcolors.WARNING + 'Resetting local dev environment...' + webpackTemplates.bcolors.ENDC)
        reset_env()



    #
    # Handle PHP Unit testing
    #
    if args.unit:
        print(webpackTemplates.bcolors.OKGREEN + 'Running phpunit tests...' + webpackTemplates.bcolors.ENDC)
        if run_unit_tests() != 0:
            print(webpackTemplates.bcolors.FAIL + 'Unit tests failed. Not progressing any further.' + webpackTemplates.bcolors.ENDC)
            sys.exit()
        else:
            print(webpackTemplates.bcolors.OKGREEN + 'Unit Test completed successfully' + webpackTemplates.bcolors.ENDC)



    #
    # Automatically add everything and commit the
    # changes to the Github repository.
    #
    if args.commit:
        print(webpackTemplates.bcolors.OKGREEN + 'Commiting to GitHub Repo...' + webpackTemplates.bcolors.ENDC)
        commit_to_github()



    #
    # Analyze everything is alright and show a small report
    #
    if args.analyze:
        print(webpackTemplates.bcolors.OKGREEN + 'Running analysis on the local repo...' + webpackTemplates.bcolors.ENDC)
        analyze_and_report()




def run_unit_tests():
    try:
        results = subprocess.run('./vendor/bin/phpunit', shell=True, check=True)
        return results.returncode
    except subprocess.CalledProcessError as e:
        print(e.output)
        return -1



def commit_to_github():
    try:
        results = subprocess.run('git add --all; git commit -m "release candidate"; git push;', shell=True, check=True)
        return results.returncode
    except subprocess.CalledProcessError as e:
        print(e.output)
        return -1



def build_template_stylesheets():
    webpackTemplates.main()



def build_app_stylesheets_and_all_scripts():
    print('Backend CSS and JS transpiling is starting...')
    webpackTemplates.run_npm_build('prod')



def analyze_and_report():

    positive = webpackTemplates.bcolors.OKGREEN + ' yes' + webpackTemplates.bcolors.ENDC
    negative = webpackTemplates.bcolors.FAIL + ' No' + webpackTemplates.bcolors.ENDC

    # check webpack.mix.js is available
    msg = webpackTemplates.bcolors.OKBLUE + '1. webpack.mix.js available in repo?'
    if os.path.isfile('./webpack.mix.js'):
        print(msg + positive)
    else:
        print(msg + negative)

    # check webpack-templates.mix.js is available
    msg = webpackTemplates.bcolors.OKBLUE + '2. webpack-templates.mix.js available in repo?'
    if os.path.isfile('./webpack-templates.mix.js'):
        print(msg + positive)
    else:
        print(msg + negative)


    # check there are no unrecognised files in the repo/templates
    msg = webpackTemplates.bcolors.OKBLUE + '3. repo/templates contains only default templates?'
    files = os.listdir('./storage/repo/templates/')
    # exclude any dot files
    templates_present = list(filter(lambda item: item.startswith(".")==False, files))
    if set(templates_present) == set(configs.DEFAULT_TEMPLATES):
        print(msg + positive)
    else:
        print(msg + negative)
        print ('Repo/templates contains:')
        print (templates_present)
        print ('Default template(s) is/are:')
        print (configs.DEFAULT_TEMPLATES)


    # check there are no unrecognised files in the view/templates
    msg = webpackTemplates.bcolors.OKBLUE + '4. view/templates contains only Serenity template?'
    files = os.listdir('./resources/views/templates/')
    # exclude any dot files
    templates_present = list(filter(lambda item: item.startswith(".")==False, files))
    if set(templates_present) == set(['Serenity']):
        print(msg + positive)
    else:
        print(msg + negative)
        print ('view/templates contains:')
        print (templates_present)

    # check all the css files for the templates are present
    msg = webpackTemplates.bcolors.OKBLUE + '5. All CSS files for Default templates are present?'
    present = True
    for file in configs.FE_CSS_FILES:
        if not os.path.isfile('./public/css/' + file):
            present = False
            print(file + ' is not present in the public/css directory.')
    if present:
        print (msg + positive)
    else:
        print (msg + negative)



    # all javascript file is present
    msg = webpackTemplates.bcolors.OKBLUE + '6. All frontend and backend javascript files are present?'
    present = True
    for file in configs.JS_FILES:
        if not os.path.isfile('./public/js/' + file):
            present = False
            print(file + ' is not present in the public/js directory.')
    if present:
        print (msg + positive)
    else:
        print (msg + negative)


    # .gitignore is present in active directory
    msg = webpackTemplates.bcolors.OKBLUE + '7. .gitignore present in views/active?'
    if os.path.isfile('./resources/views/active/.gitignore'):
        print (msg + positive)
    else:
        print (msg + negative)


    # .gitignore is present in active directory
    msg = webpackTemplates.bcolors.OKBLUE + '8. .gitignore present in views/templates?'
    if os.path.isfile('./resources/views/templates/.gitignore'):
        print (msg + positive)
    else:
        print (msg + negative)




    # check important config files are present
    # check and report stylesheets and js files

def remove_subfolders(folder):
    for filename in os.listdir(folder):
        file_path = os.path.join(folder, filename)
        try:
            if os.path.isdir(file_path):
                shutil.rmtree(file_path)
        except Exception as e:
            print('Failed to delete %s. Reason: %s' % (file_path, e))



def reset_env():
    try:
        print('Remove all the templates in templates directory')
        remove_subfolders('./resources/views/templates')

        print('Remove all the template files from the active folder')
        for filename in os.listdir('./resources/views/active'):
            file_path = os.path.join('./resources/views/active', filename)
            if os.path.isfile(file_path) and not filename.startswith("."):
                os.remove(file_path)

        print('Put the default template folder under views/templates')
        shutil.copytree('./storage/repo/templates/Serenity', './resources/views/templates/Serenity')

        print('Put the files of the default template back to active folder')
        for filename in os.listdir('./storage/repo/templates/Serenity'):
            file_path = os.path.join('./storage/repo/templates/Serenity', filename)
            shutil.copyfile(file_path, './resources/views/active/' + os.path.basename(filename))

        subprocess.run('php artisan migrate:fresh --seed', shell=True, check=True)
        subprocess.run('php artisan db:seed --class=PermissionsTableSeeder --force', shell=True, check=True)

        subprocess.run('php artisan config:clear', shell=True, check=True)
        subprocess.run('php artisan cache:clear', shell=True, check=True)
        subprocess.run('php artisan event:clear', shell=True, check=True)
        subprocess.run('php artisan route:clear', shell=True, check=True)
        subprocess.run('php artisan view:clear', shell=True, check=True)
        subprocess.run('php artisan view:analytics', shell=True, check=True)
        subprocess.run('composer dump-autoload', shell=True, check=True)

        return 0
    except subprocess.CalledProcessError as e:
        print(e.output)
        return -1




if __name__ == "__main__":
    main()
