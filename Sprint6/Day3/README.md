## Day 3:

We'll setup 2 env where we will work to export config from a dev env to a prod env, for more check below.

---

### Day 3: Work with configuration & features

- Watch: https://www.youtube.com/watch?v=mU6eetz9nKI
- Watch: https://drupalize.me/tutorial/creating-and-deploying-feature?p=893
- Read & Practice: https://www.drupalatyourfingertips.com/config

You should quickly setup two Drupal (>8) instances in your machine:

- One is your dev environment.
- The other one will act as your production environment.

In your dev environment:

- Install devel using composer and enable it.
- Create a taxonomy
- Create a basic content type with fields of your choice (make sure to have one which reference the taxonomy your created)
- Create a new role and setup proper permissions: Only users with that role will have access to manage your new content type.

##### Practice Configuration Sync

Your job, is to export your dev website configuration and import it in the production website.

You should not take any other steps after importing the configuration, you may clear the cache but nothing else. And everything should be working.

Have a look at https://www.drupal.org/project/config_split

Question:

- Was devel installed in the production environement ? Devel is dev tool and should not be present in the production

##### Practice Features

Now, do the same, but use Feature module to export your configuration as a module with only the parts needed (content type, taxonomy, fields if any, config ...).
Your production site should have features module installed and enabled but not feature ui. You should use drush to enable and import your module
After enabling the module in production, edit your content type and change it name (in production).
Now add a new field to your content type in your dev env and export the module again, then import it in the production.

Question:

- Was their any conflicts that needed to be resolved ?

> NOTE: Make sure to share screenshots & code in your daily report.

---

## Author

- [`@Josh-techie`](https://github.com/Josh-techie)| Software Engineer Student

  > Reach out to me if you need any help or have any questions.

  <a href="mailto:youssef.abouyahia@e-polytechnique.ma">
  	<img alt="Feel free to contact me" src="https://img.shields.io/badge/-Ask_me_anything-blue?style=flat&logo=Gmail&logoColor=white&link=mailto:youssef.abouyahia@e-polytechnique.ma&color=3d85c6" />
  </a>
  <span> | </span>
    <a href="https://www.linkedin.com/in/youssef-abouyahia/">
        <img alt="Linkedin Profile" src="https://img.shields.io/badge/-Linkedin-0072b1?style=flat&logo=Linkedin&logoColor=white&link=https://www.linkedin.com/in/youssef-abouyahia/" />
    </a>
    <span> | </span>
    <a href="https://twitter.com/JoesephAb">
        <img alt="Twitter Profile" src="https://img.shields.io/badge/-Twitter-0072b1?style=flat&logo=Twitter&logoColor=white&link=https://twitter.com/JoesephAb&color=1DA1F2" />
    </a>
