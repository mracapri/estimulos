insert into evaluador (RFC_evaluador, nombre, tipo, anio) values ('RIAM821203', 'Mario Rivera Angeles', 'I', 2012);
insert into evaluador (RFC_evaluador, nombre, tipo, anio) values ('TAAM801205', 'Jose Juan Martinez Perez ', 'I', 2012);

insert into evaluacion (anio, descripcion, fecha_captura, fecha_limite_captura, fecha_evaluacion, fecha_limite_evaluacion) 
values (2011, 'Evaluacion 2012', DATE('2012/01/12'), DATE('2012/01/12'), DATE('2012/01/12'), DATE('2012/01/12'));

insert into evaluacion (anio, descripcion, fecha_captura, fecha_limite_captura, fecha_evaluacion, fecha_limite_evaluacion) 
values (2010, 'Evaluacion 2012', DATE('2012/01/12'), DATE('2012/01/12'), DATE('2012/01/12'), DATE('2012/01/12'));

insert into reportes (id_reporte, nombre, path) values (1, 'Reporte 1', 'reporte1.php');
insert into reportes (id_reporte, nombre, path) values (2, 'Reporte 2', 'reporte2.php');