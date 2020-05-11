
# StudIP-SimpleBBB-Connector  
  
To use the connector you need the api-informations for your BBB-Server.   
  
  
To get the information run bbb-conf --secret on your BBB-Server/s  
  
Add the server via server add in the sidebar of the overview.  
  
You can use the plugin roles to determine who can see this information. In principle, adding is only possible for root.  
  
## Greenlight-Connection  
To read the Greenlight database, Greenlight has to accept remote connections.   
In the docker-compose.yaml either remote connection via   
    `ports:  
	 - 5432: 5432` 

or add the desired IP  

`ports:  
	 - 127.0.0.1:5432:5432 - x.x.x.x:5432:5432`  

Then enter the connection data in the configuration:  
  
`
{
	"host": 
		{
			"production":"hostadr",
			"development":"hostadr"
		},
	"user":"USER",
	"password":"PASSWORD",
	"schema":"greenlight_production"
}`