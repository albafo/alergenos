<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">


    <style>
        @page {
            size: A4;
            margin: 0;
        }

        /*@media print {*/
            html, body {
                width: 210mm;
                height: 297mm;
                max-height: 297mm;
                font-family: sans-serif;

            }

            .cabecera {

                width: 100%;
                text-align: right;
                margin-top: -5mm;
            }

            .pieTexto {
                position: absolute;
                bottom: 12mm;
                text-align: center;
                width: 100%;
            }

            .pieLogos {
                position: absolute;
                bottom: -5mm;
                text-align: right;
                width: 100%;


            }

            .pieLogos img {
                margin-left: 3mm;
            }

            .col-izq {
                width: 70mm;
                padding-left: 10mm;
                padding-right: 10mm;
                float: left;
                margin-top: -5mm;
            }

            .col-izq  img{
                width: 50mm;
            }

            .col-izq .fondo {
                margin-top: 18mm;
            }

            .col-der {
                margin-top: 5mm;
                width: 140mm;
                float: left;
                height: 240mm;
                max-height: 240mm;
                border: 1px solid #000000;
                text-align: center;
                position: relative;
            }

            .col-der p {
                margin: 0;
            }

            .col-der .p1 {
                font-size: 6mm;
            }

            .col-der .p1 strong{
                font-size: 8mm;
            }

            .col-der .p2 {
                margin-top:5mm;
                margin-bottom: 5mm;
            }

            .col-der .restaurante {
                color: #C00011;
            }

            .col-der .restaurante p{
                margin-bottom: 1mm;

            }

            .col-der .p4 {
                margin-top: 8mm;
            }

            .col-der .p5{
                margin-top: 5mm;
            }

            .col-der .p6, .col-der .p7 {
                margin-top: 5mm;
                font-size: 3mm;
            }

            .col-der .p8 {
                font-size: 3mm;
            }
            .col-der .p9 {
                font-size: 2mm;
                margin-top: 5mm;
            }

            .col-der .firmaCertificado {
                margin-top: 7mm;
            }
            .col-der .firmaCertificado img {
                margin-top: -4mm;
                height: 20mm;
            }


            .col-der .fechas .fecha {
                color: #C33145;
            }
            .col-der hr {
                margin-top: 2mm;
                margin-bottom: 2mm;
            }

            .col-der .avisoCertificado {
                position: absolute;
                bottom: 0;

            }





        /*}*/

    </style>


</head>
<body class="page-{{App\MyRequest::mySegments()}} @yield('class-body')">

    <div class="cabecera">
        <img src="{{asset('img/logo-adehon.png')}}">
    </div>
    <div class="content">
        <div class="col-izq">
            <div class="logo">
                <img src="{{asset('img/logo_ecede.png')}}">
            </div>
            <div class="fondo">
                <img src="{{asset('img/fondo-certificado.png')}}">
            </div>
        </div>
        <div class="col-der">
            <p class="p1"><strong>CERTIFICACIÓN / </strong>CERTIFICATION</p>
            <p class="p2"><strong>Concedida a / </strong>Awarded to</p>
            <div class="restaurante">
                <p class="nombreRestaurante"><strong>{{$user->nombre_establ}}</strong></p>
                <p>{{$user->direccion}}</p>

            </div>
            <p class="p4"><strong>ECEDE certifica que ha sido formado de acuerdo a los requerimientos de la NORMATIVA EUROPEA Nº 1169/2011 ALERGIAS ALIMENTARIAS</strong></p>
            <p class="p5">ECEDE certifies that has been trained in accordance with the requirements of EUROPEAN NORMATIVE Nº 1169/2011 WARNING ALLERGIES</p>
            <hr>
            <p><strong>El sistema de Adaptación se aplica a:</strong></p>
            <p>The system of Adjustment is applied to:</p>
            <p class="p6">
                <strong>Todos los operadores de empresas alimentarias en todas las fases de la cadena alimentaria.
                    Todos los alimentos destinados al consumidor final, incluidos los entregados por las colectividades y
                    los destinados al suministro de las colectividades. Y a los servicios de restauración que ofrecen las
                    empresas de transporte.
                </strong>
            </p>
            <p class="p7">
                All the operators of food companies in all the phases of the food chain. All the food destined to the final consumer, including the food delivered by the collectivities and the destined ones for the supply of the collectivities. Also to the services of hospitality and catering that offer the transport companies.
            </p>
            <hr>
            <p class="p8"><strong>ESTE ESTABLECIMIENTO DISPONE DE INFORMACIÓN RELATIVA A LA PRESENCIA DE SUSTANCIAS SUSCEPTIBLES DE CAUSAR ALERGIAS E INTOLERANCIAS EN SU OFERTA GASTRONÓMICA Y ESTÁ A DISPOSICIÓN DE TODOS LOS CLIENTES.</strong></p>
            <p class="p9">THIS LOCAL-TRADE PROVIDES INFORMATION RELATED TO THE PRESENCE OF SUBSTANCES SUSCEPTIBLE OF CAUSING ALLERGIES AND INTOLERANCES IN HIS GASTRONOMIC OFFER AND HANDLES ITS SERVICES TO ALL THE CUSTOMERS.</p>
            <div class="firmaCertificado">
                <div class="row">
                    <div class="col-xs-6 text-right">
                        <p><strong>Director de Certificación /</strong></p>
                        <p>Certification manager</p>
                    </div>

                    <div class="col-xs-4 text-left">
                        <img src="{{asset('img/firma-certificado.png')}}">

                    </div>
                </div>
            </div>
            <div class="fechas">
                <div class="row">
                    <div class="col-xs-6 text-right">
                        <strong>Fecha de vigencia:</strong><br>Efective date:
                    </div>
                    <div class="col-xs-6 text-left fecha">
                        <strong>{{strftime("%d/%m/%Y", strtotime($user->certificationDate()))}}</strong>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 text-right">
                        <strong>Certificado en vigor hasta:</strong><br>Certificate expiration date:
                    </div>
                    <div class="col-xs-6 text-left fecha">
                        <strong>{{strftime("%d/%m/%Y", strtotime($user->certificationDate() . "+ 1 year"))}}</strong>
                    </div>
                </div>
            </div>
            <div class="avisoCertificado">
                <p></p><strong>Este certificado está sujeto a los términos y condiciones generales y particulares de los servicios de certificación.</strong></p>
                <p>This certificate is valid, subject to the general and specific terms and conditions of certification <services class=""></services></p>
            </div>

        </div>
    </div>

    <div class="pieTexto">
        <p>Adehon es Centro de formación acreditado e inscrito en el registro de entidades de formación profesional para el empleo con Nº 4600000877</p>
    </div>

    <div class="pieLogos">
        <img src="{{asset('img/iso9001.png')}}"> <img src="{{asset('img/oca-certificado.png')}}">
    </div>





<!-- Scripts -->



</body>
</html>
