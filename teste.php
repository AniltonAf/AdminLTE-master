<style>
    .min{
        min-width: 400px;
    }
</style>
<?php
    `
    
    SELECT gerador_status,Count(gerador_status) as qtd FROM gerador_config GROUP BY gerador_status ORDER BY gerador_id

    
    
    `
?>