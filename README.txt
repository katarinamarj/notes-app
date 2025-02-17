MONGO - http://localhost:8000/routes/mongo-notes.php

1. create 
   method: POST
   
   {
      "title": "Sample note",
      "description": "This is a test note"
   }

2. get all
   method: POST

3. update
   method: PUT

   {
      "_id": ,
      "title": "Sample note",
      "description": "This is a test note"
   }

4. delete
   method: delete

   {
      "_id":
   }

5. dodavanje vise odjednom 
   method: POST
   pre-request script:

   // Broj iteracija za slanje podataka
const iterations = 100;  // Slanje 100 zahteva
for (let i = 1; i <= iterations; i++) {
    pm.sendRequest({
        url: 'http://localhost:8000/routes/mongo-notes.php',
        method: 'POST',
        header: {
            'Content-Type': 'application/json'
        },
        body: {
            mode: 'raw',
            raw: JSON.stringify({
                "title": `Note ${i}`,
                "description": `Description for Note ${i}`
            })
        }
    }, function (err, res) {
        if (err) {
            console.log(`Error with request ${i}:`, err);
        } else {
            console.log(`Request ${i} successful:`, res.json());
        }
    });
}

6. brisanje vise odjednom 
{
  "ids": ["", "", ""]
}



MYSQL - http://localhost:8000/routes/mysql-notes.php

method: POST
   
   {
      "title": "Sample note",
      "description": "This is a test note"
   }

2. get all
   method: POST

3. update
   method: PUT

   {
      "id": ,
      "title": "Sample note",
      "description": "This is a test note"
   }

4. delete
   method: delete

   {
      "id":
   }

5. dodavanje vise odjednom 
   method: POST
   pre-request script:

   // Broj iteracija za slanje podataka
const iterations = 100;  // Slanje 100 zahteva
for (let i = 1; i <= iterations; i++) {
    pm.sendRequest({
        url: 'http://localhost:8000/routes/mysql-notes.php',
        method: 'POST',
        header: {
            'Content-Type': 'application/json'
        },
        body: {
            mode: 'raw',
            raw: JSON.stringify({
                "title": `Note ${i}`,
                "description": `Description for Note ${i}`
            })
        }
    }, function (err, res) {
        if (err) {
            console.log(`Error with request ${i}:`, err);
        } else {
            console.log(`Request ${i} successful:`, res.json());
        }
    });
}

6. brisanje vise odjednom 
   method: DELETE 

   {
  "ids": [5, 6, 7]
   }

