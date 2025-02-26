# Scalable Web Applications - Programming Assignment 1

## Objective

Students will build a scalable web application using PHP that demonstrates core concepts 
of scalability, distributed systems architectures, concurrency, application services, and 
distributed caching. 

## Requirements and Components

### Component 1: The web Application with API Services (30 marks)

- Develop a basic event management web application with a simple three-tiered 
architecture implementation using object-oriented PHP. The web application 
should:
- Allow users to register using a valid, unique email and a strong password
stored with a strong hash algorithm. A user is assigned a unique twelvecharacter API key of the format xxx-xxxx-xxx, where x represents any 
alphanumeric character. The user has an auth_flag field that is set to either 
true or false. When the user is successfully logged in, the auth_flag field is 
true. It is false otherwise.
- Create, view and edit event details and delete events
- Event details are: a unique event id; the event name consisting of 
alphanumeric characters; the event start and end dates stored in yyyy-mmdd format; the event location, and the event price stored as a decimal to two 
decimal places, the email address of the user that created the event.
- Implement a RESTful API that follows standard HTTP methods of GET for 
retrieving data; POST for creating data; PUT for updating data and DELETE for 
removing data.

#### Create the following User authentication endpoints

- POST /register: Register a new user
- POST /login: Authenticate and log in a user, i.e. a valid email address and 
password is received, the API key is retrieved
- GET /user: Retrieve the user’s information using their email address only if 
they are successfully logged in, i.e. the auth_flag field is true.
- Create the following Event management endpoints.
- POST /events: Create a new event (requires authentication, i.e. the API key)
- GET /events: Retrieve the list of event names
- GET /events/{id}: Retrieve details of a specific event
- PUT /events/{id}: Update an event (requires authentication and event 
ownership)
- DELETE /events/{id} - Delete an event (requires authentication and event 
ownership)
#### Create the following User Registration for Events endpoints
- POST /events/{id}/register: Register the user for an event
- GET /users/{id}/events: Retrieve a list of events a user has registered for
### Component 2: Distributed Systems Design (25 marks)

- Implement a modular architecture using a client-server model.

#### Separate the application into distinct services: 

- Authentication Service: Handles user registration, login, and 
authentication.
- Event Management Service: Manages event creation, retrieval, updates, 
and deletion.
- User Registration Service: Handles user registration for events.
- Database Service: Centralized database access for all services.

#### Enable the application to run across multiple services by using RESTful APIs for inter-service communication.

- Introduce horizontal scaling by allowing multiple instances of the services to run 
concurrently.
- Use Docker to containerize the application for portability: 
- Create a Dockerfile for each microservice.
- Use Docker Compose to define multi-container applications.
- Expose services using distinct ports and configure networking between 
them.
- Store persistent data in a shared database accessible by all microservices.

#### Implementation Details

1. Design the Microservices
- Define separate directories for each service (e.g., auth_service/, 
event_service/, user_registration_service/).
- Implement a PHP APIs for each service.
- Define a central database connection service for shared data access.

2. Implement Inter-Service Communication
- Use HTTP API calls for service-to-service interactions.
- Implement service discovery by maintaining an API gateway or service 
registry.

3. Set Up Docker and Docker Compose
- Write individual Dockerfile for each service.
- Use docker-compose.yml to define multi-container setup.
- Expose and link services using Docker’s internal networking.

4. Run Multiple Instances for Scalability
- Configure Docker Compose scaling (e.g., docker-compose up --scale 
event_service=3).
- Use NGINX as a reverse proxy to load-balance between instances.

### Component 3: Load Balancing and Distributed Caching (25 marks)

• Implement and configure NGINX or Apache as a load balancer to distribute 
requests across multiple instances.
• Set up Redis or Memcached for caching frequently accessed data.
• Report Requirement: 
- Explain how caching improves response times.
- Compare performance with and without caching.
- Include screenshots of response times and load test results.
- Provide an analysis of cache hit/miss ratios and recommendations for further 
optimization.

### Component 4: Performance Monitoring and Scalability Analysis (20 marks)
• Use Apache JMeter or Locust to simulate high loads and measure response time, 
throughput, and system stability.
• Implement Prometheus and Grafana for monitoring system metrics.
• Report Requirement:
- Include load test results and explain findings.
- Analyze system bottlenecks and propose solutions.
- Provide screenshots of monitoring dashboards.
- Discuss scalability limits and suggest future improvements.
