<link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid.min.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/third-party/jsgrid-1.5.3/dist/jsgrid-theme.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/third-party/jsgrid-1.5.3/dist/jsgrid.min.js"></script>
<?php echo js("candidatos_curso/grid_candidatos.js"); ?>
<script >
    var cat_tipo_cargas = <?php  echo $tipo_cargas;?>;
    var cat_delegacioes = <?php  echo $delegaciones;?>;
</script>

<div id="grid_candidatos" name="grid_candidatos"></div>


