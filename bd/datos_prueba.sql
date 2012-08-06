
/* Evalacion actual */
insert into evaluacion (anio, descripcion, fecha_captura, fecha_limite_captura, fecha_evaluacion, fecha_limite_evaluacion) 
values (2012, 'Evaluacion 2012', DATE('2012/07/25'), DATE('2012/07/29'), DATE('2012/08/01'), DATE('2012/08/05'));

/* agregando evaluadores */

/*insert into evaluador (RFC_evaluador, nombre, tipo, anio) values ('TETE750801', 'Elia Trejo Trejo', 'I', 2012);*/
insert into evaluador (RFC_evaluador, nombre, tipo, anio) values ('MENN901110', 'Noemi Mejia Nieto ', 'E', 2012);

/* Reportes del sistema */
insert into reportes (id_reporte, nombre, path) values (1, 'Reporte 1', 'reporte1.php');
insert into reportes (id_reporte, nombre, path) values (2, 'Reporte 2', 'reporte2.php');

/* Agregando participantes */

insert into participantes (rfc, anio) values ('AACC760815', 2012);
insert into participantes (rfc, anio) values ('TELL671024', 2012);
insert into participantes (rfc, anio) values ('RIAM821204', 2012);





