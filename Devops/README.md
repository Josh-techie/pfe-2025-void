# Drupal Production Migration and Containerization

## Overview

Ultimate goal from this project is to train to realize later the process of migrating a production-ready Drupal website from one server to another, ensuring the application functions smoothly, securely, and with the appropriate version. While this project is more to get hand on experience to creating a custom Docker image to facilitate easy deployment and management of the Drupal application as well as to get familiare with the services crucial for a seamless experience for a drupal production ready website.

## Problem Statement

Migrating a Drupal website requires careful planning and execution to avoid data loss, downtime, and security vulnerabilities. The process needs to ensure compatibility with the target server environment while maintaining the website's functionality and data integrity.

## Solution

To address the migration challenge, the following steps were taken:

1.  **Familiarization with Docker and Services:**

    - Utilized Docker Compose to set up a local development environment with all the necessary services for a Drupal website (e.g., MySQL, phpMyAdmin, MailHog).
    - Gained hands-on experience with configuring and managing these services using Docker.

2.  **EasyPanel Setup and Manual Service Creation:**

    - Created a virtual machine (VM) and installed Docker on it.
    - Deployed EasyPanel within a Docker container on the VM.
    - Manually configured the necessary services for Drupal within EasyPanel, replicating the setup from the Docker Compose environment.

3.  **Custom Drupal and Nginx Docker Image:**

    - Created a custom Dockerfile to build a single container that includes both the Drupal application and the Nginx web server.
    - Ensured the Dockerfile:
      - Installs all required dependencies.
      - Configures Nginx to serve the Drupal website.
      - Sets appropriate file permissions and security measures.
      - Automates Drupal project creation
      - Automates Drupal sites/default/settings.php setup

4.  **Docker Hub Image Publishing:**

    - Pushed the custom-built Docker image to Docker Hub, making it easily accessible for deployment.
    - Docker Hub Repository: [https://hub.docker.com/repository/docker/joetechie/void-drupal-nginx/general](https://hub.docker.com/repository/docker/joetechie/void-drupal-nginx/general)

5.  **EasyPanel Deployment:**
    - Pulled the custom Docker image from Docker Hub into EasyPanel and deployed the application.

## Key Achievements

- Successfully containerized a production-ready Drupal website.
- Created a fully automated Dockerfile for building the Drupal and Nginx image.
- Published the Docker image to Docker Hub for easy deployment.
- Demonstrated the ability to migrate and deploy Drupal applications using modern containerization technologies.
- Set up a local Drupal website using docker in a production like environnement using easypanel.
- Familiarized myself with the necessary services for smoth functioning of a drupal website.

## Technologies Used

- Docker
- Docker Compose
- EasyPanel
- Nginx
- PHP
- MySQL
- Drupal
- Composer
- Mailhog
- PhpMyadmin

## Next Steps

- Implement automated testing for the Docker image.
- Explore continuous integration and continuous deployment (CI/CD) pipelines for automated image building and deployment.
- Implement automated backup and disaster recovery
- Implement the SSL setup to the website

---

## Security Measures

- Using an FPM base image
- Updating base image
- Setting document root on Nginx
- Doing cleanup
- Not setting the user with root

## Challenges Faced

- **PHP-FPM Configuration Issues:** Troubleshooting connection refused errors between Nginx and PHP-FPM due to misconfiguration of PHP-FPM and Nginx.
  and a lot of other problems with nginx, easypanel, connectivity issues... but have fun!

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
