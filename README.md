# Project-Lifecycle-Management-App
State exam

The application is an interface that allows registered companies to create projects and invite clients belonging to the project to the interface. This creates a “room” between the company and the client, which facilitates communication, storage of relevant documents and customer service processes.

It is a web-based application, so that it is accessible to anyone without having to download anything. Recommended technologies: PHP, HTML5, SQL DB.

The system is divided into two large parts from a logical point of view: **Company module and client module**.

**Function list**

**Company module**

A company can register on the platform if it uploads the required company data.
When registering a company, an Admin user is also created, who can then log in to the application at any time based on their email address and password
Users also have a “Forgot my password” option, through which they can reset their password
After logging in, the admin user sees a “Dashboard” with the most relevant information, such as projects, users, news
The admin user can invite colleagues to the interface, who can activate their users via an email notification and log in.
The company admin can create projects, giving them a name, duration and selecting relevant colleagues for the project.
The company admin can send an invitation to a created project to the client and from there a “room” is created between the company and the client
The project has a news feed section where both the company’s employees and the client can open a certain discussion topic, under which users can communicate in the form of comments
The necessary documents can be uploaded to the project: contracts, attachments, corporate manuals, quotes, invoices, account statements and other documents. PDF and image documents can be opened with a click, and the rest can be downloaded.
The company’s employees can see the bugs created by the client in the form of a to-do list with a status and a priority and an optional deadline
The company’s employees can change the status of the task: in progress/completed, etc.

**Client module**

The client can activate his user based on the instructions in the email invitation
After logging in, the client can view the projects to which he has been added via the interface
The client can enter the internal page of a project, where he can access all information about the project, access and upload documents, open new topics and create tasks
The client can create new feature requests or bugs within a project, which will then appear in a list view for the company's employees. When a new document is uploaded or a new task is created, the project members are notified by email.
