# README del Projecte Biel & Amin

Aquest és el nostre README, on es troben els nostres diagrames de casos d'ús, el model entitat-relació i el manual dús de l'usuari.
  

## GESTIÓ D'INCIDÈNCIES BIEL & AMIN DIAGRAMA DE CASOS D'ÚS
Aquest és el nostre diagrama de casos d'ús per al projecte. Representa les funcionalitats clau i com interactuen els diferents actors amb el sistema.
- Aquesta aplicació web té com a objectiu millorar la gestió i resolució d'incidències tècniques dins d'una organització. Els usuaris poden registrar incidències, consultar-ne l'estat i seguir el seu progrés fins a la resolució. L'aplicació també proporciona eines per als tècnics i administradors, que poden gestionar les incidències i consultar informes detallats.


## FUNCIONALITATS PRINCIPALS:

1. **Per a Usuari General** es registrarà una nova incidència i es consultarà l'estat de la incidència.

2. **Per a Tècnic** es veurà les incidències assignades, registrar l'actuació i es tancarà la incidència.

3. **I per Administrador** es modificarà la incidència, es consultarà informes i es consultarà les estadístiques d'accés.

- ![Diagrama de casos d'ús ](https://github.com/user-attachments/assets/c2808011-e8ff-43b2-9f52-ec7b65faeafb)


## MODEL ENTITAT-RELACIÓ

El model entitat-relació mostra com s'estructuren i com es relacionen les diferents entitats dins del nostre sistema de recopilació d'incidències.

- **Usuari**: Persona que pot crear o veure incidències.  
- **Incidència**: És el problema a tractar.  
- **Prioritat**: Depenent de quin tipus d'incidència es tracti (depenent del que l'usuari introdueixi en el formulari).  
- **Tipus d'incidència**: Segons la descripció de l'usuari, la incidència serà d'un tipus o d'un altre (de software, el ratolí, el teclat, etc.)  
- **Estat**: Aquesta entitat fa referència a l'estat en el qual es troba la incidència.  
- **Tècnic**: Persona encarregada de resoldre incidències.  
- **Departament**: Cada incidència té associat un departament.  
- **Actuació**: Els tècnics, cada cop que arreglin o avancin en resoldre una incidència, ho faran mitjançant aquesta entitat.  

*A continuació mostrem el diagrama que representa aquestes entitat i les seves relacions i atributs.*

![Model_Entitat-Relació](php/img/Model_Entitat-Relació.png)

# USER MANUAL
Welcome to the User Manual of the IT Issue Manager of Institut Pedralbes.

This app is made by Amin and Biel, and in these manual we are going to explain how the website works and the specific functions for each type of user (user, technician, and admin).

## ACCESS TO THE WEBSITE
When you enter our website, you will see the landing page. In the middle of the app, there is a button to access the main website.

## FIRST PAGE
Once you are on the first page, you will find a brief explanation about the website and a login button to enter the app based on your role.

## USER PAGE: How to Report an IT Issue
There are 2 main functions on this page:
- **Report an IT Issue:**
 By choosing this option, you will be redirected to a form. Fill in the required fields to report your issue (department name, problem description, who you are, etc.).

- **Follow all your reports:**
 After making a report, you will need to provide your email address. This will allow you to track the progress of your reports, such as the status of the issue and how many times technicians have worked on it.



## TECHNICIAN PAGE: How to Manage Assignments
On the technician page, there is 1 main function:
- **See all your assignments:**
 To see your assignments, enter your technician ID (the one provided by the school). The page will display all your assignments, sorted by priority.
 If you want to close a report or report an action, there is a button that redirects you to a form. In this form, you will need to describe the action taken, the time spent on it, and whether the issue is resolved or still ongoing.


## ADMIN PAGE: Managing Reports and Assignments
The admin page has 3 main functions:
- **See all the reports:**
 Here, you can view all the reports and their details, including which technician is responsible, the department, and more. You can also edit reports. Specifically, you can change the assigned technician, set or change the priority, and define the type of issue (e.g., mouse, monitor, software, etc.).

- **See all the actions of the technical team:**
 On this page, you can view the actions performed by each technician.

- **See the total number of reports and actions per department:**
 This page provides statistics about the number of issues reported by each department.
