# ContextTracker

This is a Maleficarum framework component. 

Features:
- Track context through request/message handling cycle
- Inject context into HTTP/AMQP Headers 
- Extract context from HTTP/AMQO Headers

#Installation

Depending on Your setup installation will differ:

#Proxy 

##For proxy service NOT using maleficarum-proxy

Initialize Http Context in Your main initializer e.g. src/Initializer.php

```
\Maleficarum\ContextTracing\Initializer\HttpInitializer::initialize([
            'context.service_name' => 'voucher_service-proxy'
]);
```
Pass service name for context purpose 

## For proxy service using maleficarum-proxy

@TODO

#API

## For api services using maleficarum-api

###input

add package with composer

in index.php add paremeters via setParamContainer

```
'logger.plugins' => [
   [\Maleficarum\ContextTracing\Plugin\MaleficarumMonologLogger::class, 'addProcessor']
],
'context.service_name' => 'ejector_service-api'
```

and add via setInitializers

```
[Maleficarum\ContextTracing\Initializer\HttpInitializer::class, 'initialize']
```

This will both initialize http context and plug it into logger 

You will also need to upgrade logger packages 

###output

Depending on which package You are using to produce messagee:

#### maleficarum-rabbitmq
Just upgrade - will work out of the box

#### publisher

@todo

##For api service using miinto-api

@todo

#Worker 

##For worker service using maleficarum worker

###input and output

just upgrade maleficarum-worker will work out of the box

###logger

Worker has seperate logger. You need to switch facility from syslog to context in You config:
```
;##
;# LOGGER settings
;##
[logger]
facilities[] = 'cli'
facilities[] = 'context'
```







