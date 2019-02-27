call doctrine-module orm:convert-mapping annotation module/Shop/src/ --namespace="Shop\Entity\\" --from-database
call doctrine-module orm:generate-entities module/Shop/src/ --generate-annotations=true