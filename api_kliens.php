<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESTful API Kliens</title>
    <script>
        async function sendRequest_get(method, url, data = null) 
        {
           
           
                const userID = document.getElementById('get-id').value;
                fetch('./rest_api.php?id='+userID,
                {
                    method: method,
                    headers: { 'Content-Type': 'application/json' },
                    //body: JSON.stringify({ id : userID })
                })
                .then(response => {
                                if (!response.ok) {
                                    throw new Error(`Hiba: ${response.status} - ${response.statusText}`);
                                }
                                return response.json(); // A válasz JSON-ként való feldolgozása
                                
                            })
                .then(data => 
                           {
                            document.getElementById('output').innerText = JSON.stringify(data, null, 4);
                            
                                
                            })
                .catch(error => console.error('Hiba:', error));
   
                
                
           
        }

        async function sendRequest(method, url, nev, osztaly) 
        {
           
           
                const userID = document.getElementById('get-id').value;
                fetch('./rest_api.php',
                {
                    method: method,
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ nev: nev, osztaly: osztaly })
                })
                .then(response => {
                                if (!response.ok) {
                                    throw new Error(`Hiba: ${response.status} - ${response.statusText}`);
                                }
                                return response.json(); // A válasz JSON-ként való feldolgozása
                                
                            })
                .then(data => 
                           {
                            document.getElementById('output').innerText = JSON.stringify(data, null, 4);
                            
                                
                            })
                .catch(error => console.error('Hiba:', error));
   
                
                
           
        }

        async function sendRequest_update(method, url, id, nev, osztaly) 
        {
           
           
                const userID = document.getElementById('get-id').value;
                fetch('./rest_api.php?id='+id,
                {
                    method: method,
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({  nev: nev, osztaly: osztaly })
                })
                .then(response => {
                                if (!response.ok) {
                                    throw new Error(`Hiba: ${response.status} - ${response.statusText}`);
                                }
                                return response.json(); // A válasz JSON-ként való feldolgozása
                                
                            })
                .then(data => 
                           {
                            document.getElementById('output').innerText = JSON.stringify(data, null, 4);
                            
                                
                            })
                .catch(error => console.error('Hiba:', error));
   
                
                
           
        }

        async function sendRequest_delete(method, id) 
        {
           
                fetch('./rest_api.php?id='+id,
                {
                    method: method,
                    headers: { 'Content-Type': 'application/json' }
                })
                .then(response => {
                                if (!response.ok) {
                                    throw new Error(`Hiba: ${response.status} - ${response.statusText}`);
                                }
                                return response.json(); // A válasz JSON-ként való feldolgozása
                                
                            })
                .then(data => 
                           {
                            document.getElementById('output').innerText = JSON.stringify(data, null, 4);
                            
                                
                            })
                .catch(error => console.error('Hiba:', error));
   
                
                
           
        }


        function getRecords() {
            
            const id = document.getElementById('get-id').value;
            
            const url = id ? `http://localhost/beadando/rest_api.php?id=${id}` : `http://localhost/beadando/rest_api.php`;
            sendRequest_get('GET', url);
           
        }

        function createRecord() {
            const nev = document.getElementById('post-nev').value;
            const osztaly = document.getElementById('post-osztaly').value;
            const data = { nev: nev, osztaly: osztaly };
            sendRequest('POST', 'http://localhost/beadando/rest_api.php',  nev, osztaly);
        }

        function updateRecord() {
            const id = document.getElementById('put-id').value;
            const nev = document.getElementById('put-nev').value;
            const osztaly = document.getElementById('put-osztaly').value;
            const data = { nev: nev, osztaly: osztaly };
            sendRequest_update('PUT', `http://localhost/beadando/rest_api.php`, id, nev, osztaly);
        }

        function deleteRecord() {
            const id = document.getElementById('delete-id').value;
            sendRequest_delete('DELETE',  id);
        }
    </script>
</head>
<body>
    <h1>RESTful API Kliens</h1>

    <section>
        <h2>GET - Adatok lekérése</h2>
        <label for="get-id">ID (opcionális):</label>
        <input type="text" id="get-id" placeholder="Adjon meg egy ID-t (vagy hagyja üresen)">
        <button onclick="getRecords()">Lekérdezés</button>
    </section>

    <section>
        <h2>POST - Új rekord létrehozása</h2>
        <label for="post-nev">Név:</label>
        <input type="text" id="post-nev" placeholder="Adja meg a nevet">
        <label for="post-osztaly">Osztály:</label>
        <input type="text" id="post-osztaly" placeholder="Adja meg az osztályt">
        <button onclick="createRecord()">Létrehozás</button>
    </section>

    <section>
        <h2>PUT - Rekord frissítése</h2>
        <label for="put-id">ID:</label>
        <input type="text" id="put-id" placeholder="Adja meg az ID-t">
        <label for="put-nev">Név:</label>
        <input type="text" id="put-nev" placeholder="Adja meg az új nevet">
        <label for="put-osztaly">Osztály:</label>
        <input type="text" id="put-osztaly" placeholder="Adja meg az új osztályt">
        <button onclick="updateRecord()">Frissítés</button>
    </section>

    <section>
        <h2>DELETE - Rekord törlése</h2>
        <label for="delete-id">ID:</label>
        <input type="text" id="delete-id" placeholder="Adja meg az ID-t">
        <button onclick="deleteRecord()">Törlés</button>
    </section>

    <h2>Eredmény</h2>
    <pre id="output" style="border: 1px solid #ccc; padding: 10px; background: #f9f9f9;"></pre>
</body>
</html>
