## RipeStat
Simple PHP wrapper around [Ripe AbuseContactFinder](https://stat.ripe.net/docs/data_api#AbuseContactFinder)

### Install RipeStat

     composer require jover/ripe-stat
     
### Using it 

     use RipeStat\AbuseContactFinder;
     
     // normal use
     $rs = new AbuseContactFinder(); 
     
     // If you make a lot of calls, get a sourceapp id from ripe :)
     $rs = new AbuseContactFinder('my sourceapp id');
     
     // making a call
     $data = $rs->get('ip, asin, or prefix');
     
     print_r($data);
     
### Example
see [example.php](example/example.php)
