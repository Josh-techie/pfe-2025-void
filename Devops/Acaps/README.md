## Steps:

1. Create the docker compose file (check the file)
2. Access the phpmyadmin
   - You might encounter a problem with upload limit that's why you add this env var:
     `UPLOAD_LIMIT: 1024M`
3. Export the database from the cpanel (Head to PHPMYADMIN)
4. You can then either use phpmyadmin or just docker cp (to copy the exported db to the container then import it using the command as follows: `mysql -u root -p acapsv2lapreprod_db < /home/acapsv2lapreprod_db.sql`)
5. Now you can just head to the final deployed project

Note: Don't forget to change `settings.php` accordingly to the credentials of the db I did put docker-compose file.

---

`Final Work Deployed:`

![alt text](image-1.png)
