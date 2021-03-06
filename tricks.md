# Tricks

## Tinker

get into tinker: `php artisan tinker`

* create admin user: `factory(App\Models\Admin::class)->create();`
* find a user: `$user = App\Models\User::where('university_id', "scunningham")->first();`

## Authentication / Roles

* authenticate for devel:
  * in `routes/web.php` file add `auth()->loginUsingId(App\Models\Admin::first()->id);` to login as the first admin found
  * or in `routes/web.php` file add 

      ```
      $hack_user = getenv('HACK_USER');

      if (!empty($hack_user)) {
          auth()->loginUsingId(App\Models\User::where('university_id',$hack_user) -> first()->id);
      }
      ```

  * assign permissions to user: 
    * `$user->assignReadOnlyAdminPermissions();`
    * `$user->assignBasicAdminPermissions();`
    * `$user->assignElevatedAdminPermissions();`
  * list abilities: `$abilities = $user->getAbilities();`
  
## Cleaning Out the DB

* find a specific milestonetype: `$mst = App\Models\MilestoneType::where('name', "PGR Study Plan")->first();`
* count the total of the milestones of this type: `$mst->milestones->count();`
* count the total of the milestones of this type not submitted yet: `$mst->milestones()->where('submitted_date', null)->count();`
* delete all milestones that are not submitted of that type: `$mst->milestones()->where('submitted_date', null)->delete();`
* count all milestones of a type that have no approvals yet: `$mst->milestones()->has('approvals','<','1')->count()`


## Development

* use `docker-compose -f docker-compose-devel.yaml up` to fire up the development deployment
* the local source directory is deployed as the main app directory in development, so the following might have to be run in the container:
  * Enter the container with `docker-compose -f docker-compose-devel.yaml exec pgr bash`
  * run `composer install`
  * `yarn`
  * `yarn run production`
  * You can now leave the container

## Data Import

* `docker exec -i pgrsystem_db_1 mysql -B -uroot pgr_saml < ~/pgr201804251312.sql`

## Backup to S3

* https://www.zenko.io/blog/backup-files-s3-server-duplicity/
* configure `boto` in `/etc/boto.cfg`
* `PASSPHRASE=foo duplicity --file-prefix-archive backup- /srv/pgr s3://s3-eu-west-1.amazonaws.com/uol-pgr-backup`
* set up lifecycle rule on S3 bucket: https://aws.amazon.com/blogs/aws/archive-s3-to-glacier/
