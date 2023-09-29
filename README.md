EvenementenCMS

This project is to create a CMS for managing events. 
Admins should be able to add/delete/update events and there will
be API-endpoints for the frontend where users can choose to
participate in certain events.

Underneath the CMS there will be a custom framework, the only off-the-shelf
modules used in this project are:
- Twig (a templating engine)
- phpdotenv (for retrieving env variables)
- psr interfaces

**Database**

- events
  - id
  - name
  - created_on
  - image_id
- users
  - id
  - name
  - email
- participants (pivot table)
  - id
  - event_id
  - user_id
- images
  - id
  - name
  - file_extension