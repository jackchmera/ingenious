# Notes to the assessment 🧑‍💻👩‍💻
The task was completed with the following assumptions:

### 1. Coding Style

The style enforced by the code sniffer was applied. In areas not covered by the code sniffer's control, I tried to maintain the style used in the repository. This also explains the absence of PHPDoc documentation. The code was written following the principle of self-documenting code.

### 2. PHP version

Although the PHP version defined in the composer.json is ^8.0.2 (which would allow using PHP version 8.3), since the PHP container provides version 8.2.24, I have assumed that this version is the one to use.

This results in some implications, such as DateImmutable objects returning the standard Exception instead of the DateMalformedStringException.

### 3. Billed Company

The invoice description mentions the Billed Company. However, the existing database structure does not allow storing this relationship.

I assumed that I would not modify the database structure. The BilledCompany entity is thus mocked to always provide the same set of data. I assumed that only one entity, Ingenious, would issue all the invoices.

In the real world, a migration would need to be created to adjust the database structure to allow storing this relationship. It would then operate similarly to the Company entity.

If this could affect the evaluation, I would be happy to complete this task.

### 4. Unit Tests

I took the opportunity to write unit tests for my Models.

Integration and functional tests could also prove extremely useful. However, I assumed that this task falls outside the scope of this assignment.

If this could affect the evaluation, I would be happy to complete this task.

### 5. DDD

In practice, different approaches to implementing DDD are used. I tried to stay as close as possible to what I observed in the provided repository.


# Recruitment Task 🧑‍💻👩‍💻

### Invoice module with approve and reject system as a part of a bigger enterprise system. Approval module exists and you should use it. It is Backend task, no Frontend is needed.
---
Please create your own repository and make it public or invite us to check it.


<table>
<tr>
<td>

- Invoice contains:
  - Invoice number
  - Invoice date
  - Due date
  - Company
    - Name 
    - Street Address
    - City
    - Zip code
    - Phone
  - Billed company
    - Name 
    - Street Address
    - City
    - Zip code
    - Phone
    - Email address
  - Products
    - Name
    - Quantity
    - Unit Price	
    - Total
  - Total price
</td>
<td>
Image just for visualization
<img src="https://templates.invoicehome.com/invoice-template-us-classic-white-750px.png" style="width: auto"; height:100%" />
</td>
</tr>
</table>

### TO DO:
Simple Invoice module which is approving or rejecting single invoice using information from existing approval module which tells if the given resource is approvable / rejectable. Only 3 endpoints are required:
```
  - Show Invoice data, like in the list above
  - Approve Invoice
  - Reject Invoice
```
* In this task you must save only invoices so don’t write repositories for every model/ entity.

* You should be able to approve or reject each invoice just once (if invoice is approved you cannot reject it and vice versa.

* You can assume that product quantity is integer and only currency is USD.

* Proper seeder is located in Invoice module and it’s named DatabaseSeeder

* In .env.example proper connection to database is established.

* Using proper DDD structure is mandatory (with elements like entity, value object, repository, mapper / proxy, DTO).
Unit tests in plus.

* Docker is in docker catalog and you need only do 
  ```
  ./start.sh
  ``` 
  to make everything work

  docker container is in docker folder. To connect with it just:
  ```
  docker compose exec workspace bash
  ``` 
