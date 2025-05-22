# config valid for current version and patch releases of Capistrano
lock "~> 3.17.0"

set :application, "vactory_drupal"
set :repo_url, "git@bitbucket.org:adminvoid/vactory8.git"
set :app_path, '.'
set :keep_releases, 2
set :deploy_via, :remote_cache
set :decompose_web_service, :php
set :decompose_restart, [:php]
set :linked_files, fetch(:linked_files, []).push('oauth-keys/private.key')
set :linked_files, fetch(:linked_files, []).push('oauth-keys/public.key')
set :decompose_compose_file, "docker-compose.prod.yml"

# Default branch is :master
# ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

# Default deploy_to directory is /var/www/my_app_name
# set :deploy_to, "/var/www/my_app_name"

# Default value for :format is :airbrussh.
# set :format, :airbrussh

# You can configure the Airbrussh format using :format_options.
# These are the defaults.
# set :format_options, command_output: true, log_file: "log/capistrano.log", color: :auto, truncate: :auto

# Default value for :pty is false
# set :pty, true

# Default value for :linked_files is []
# append :linked_files, "config/database.yml"

# Default value for linked_dirs is []
# append :linked_dirs, "log", "tmp/pids", "tmp/cache", "tmp/sockets", "public/system"

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for local_user is ENV['USER']
# set :local_user, -> { `git config user.name`.chomp }

# Default value for keep_releases is 5
# set :keep_releases, 5

# Uncomment the following to require manually verifying the host key before first deploy.
# set :ssh_options, verify_host_key: :secure
namespace :vactory_decoupled do
  desc 'setup oauth keys'
  task :setup_oauth_keys do
    on roles(:app) do
      within release_path do
        execute "touch #{release_path}/docker-build-#{Time.now.strftime("%m-%d-%Y--%H-%M-%S")}.log"
        execute "rm -rf #{release_path}/oauth-keys"
        execute "mkdir -p #{release_path}/oauth-keys"
        execute "cp #{fetch :oauth_private_key} #{release_path}/oauth-keys/private.key"
        execute "cp #{fetch :oauth_public_key} #{release_path}/oauth-keys/public.key"
      end
    end
  end

  after 'decompose:load:defaults', 'vactory_decoupled:setup_oauth_keys'
end

# namespace :deploy do
#     after :updated, 'vactory_decoupled:setup_oauth_keys'
# #     after :published, 'decompose:clean'
# #     after :published, 'decompose:build'
# #     after :published, 'decompose:restart'
# end
