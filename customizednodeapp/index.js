//http module

http = require('http');
url = require('url');

//hostname
const hostname = '127.0.0.1';
//portname
const port = 3000;

const cars = [
    {
        make:'audi',
        model:'a3',
        year: '2015',
        price: 10000,
        transmission: 'automatic', 
        url: 'https://cdni.autocarindia.com/Utils/ImageResizer.ashx?n=http%3A%2F%2Fcms.haymarketindia.net%2Fmodel%2Fuploads%2Fmodelimages%2FAudi-A6-251020191920.jpg&h=300&w=450&q=100'
    },
    {
        make:'audi',
        model:'b class',
        year: '2018',
        price: 20000,
        transmission: 'manual', 
        url: 'https://images.carandbike.com/car-images/large/audi/r8/audi-r8.jpg?v=6'
    },
    {
        make:'ford',
        model:'a3',
        year: '2018',
        price: 10000,
        transmission: 'manual', 
        url: 'https://cdn.autoportal.com/img/new-cars-gallery/ford/aspire/colors/2443e2cf19bc6fa3b64a0424ffb749b7.jpg'
    },
    {
        make:'audi',
        model:'b class',
        year: '2018',
        price: 12000,
        transmission: 'manual', 
        url: 'https://images.carandbike.com/car-images/large/audi/r8/audi-r8.jpg?v=6'
    },
    {
        make:'ford',
        model:'a3',
        year: '2018',
        price: 15000,
        transmission: 'manual', 
        url: 'https://cdn.autoportal.com/img/new-cars-gallery/ford/aspire/colors/2443e2cf19bc6fa3b64a0424ffb749b7.jpg'
    },
    {
        make:'audi',
        model:'b class',
        year: '2018',
        price: 11000,
        transmission: 'manual', 
        url: 'https://images.carandbike.com/car-images/large/audi/r8/audi-r8.jpg?v=6'
    },
    {
        make:'ford',
        model:'a3',
        year: '2018',
        price: 13000,
        transmission: 'manual', 
        url: 'https://cdn.autoportal.com/img/new-cars-gallery/ford/aspire/colors/2443e2cf19bc6fa3b64a0424ffb749b7.jpg'
    }
];



//callback function to be executed when a user makes a request to our server
const respond = (request,response) => {
    if(request.url !=='/favicon.ico'){
        console.log(request.url);
        const query = url.parse(request.url, true).query;
        console.log(query);
        const pathname = url.parse(request.url, true).pathname;
        console.log(pathname);
        
        
        response.setHeader('Content-Type', 'text/plain');
        response.writeHead(200,{'Content-Type': 'text/html'});
        //response.write sends the body of the response
        
        response.write(`<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>JS Bin</title>
<style>
p{
color: green;
}

</style>
</head>

<body>`);
response.write('<p> node is fun </p>'); 
    
const check = car =>(query.make===undefined || query.make === car.make)&&(query.model === car.model || query.model ===undefined)&& (query.year === undefined  || query.year === car.year)&&(query.transmission === undefined || query.transmission === car.transmission)&&
      (query.minprice === undefined || parseInt(query.minprice)<car.price)&&
      (query.maxprice === undefined || parseInt(query.maxprice)>car.price);


if(pathname === '/cars'){
            cars.filter(check).forEach(car =>{
                
                response.write(`
<hr>
<img src = '${car.url}' height = '200' alt = 'car'>
<p>Make: ${car.make}</p>
<p>Transimission: ${car.transmission}</p>
<p>Model: ${car.model}</p>
<p>Price: ${car.price}</p>
`);
            });
        }
                
                                     
response.end(`</body>
</html>`);
        
    }
};



//create a server
const server = http.createServer(respond);

//listen to user request
server.listen(port, hostname, ()=>{console.log(`listenning on port: ${port}, 
${hostname}`)});