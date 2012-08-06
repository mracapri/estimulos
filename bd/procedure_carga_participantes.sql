DELIMITER $$
DROP PROCEDURE IF EXISTS cargaParticipantes $$
CREATE PROCEDURE cargaParticipantes()
BEGIN
	DECLARE done INT DEFAULT FALSE;
	DECLARE llaveDuplicada INT DEFAULT FALSE;
	DECLARE rfcDocente VARCHAR(10) DEFAULT '';
	DECLARE cursorParticipantes CURSOR FOR 
		SELECT b.rfc as rfc
		FROM siin_generales.gral_usuarios_adscripcion a, siin_generales.gral_usuarios b
		WHERE a.idperiodo IN (select idperiodo from siin_generales.gral_periodos where actual = 1)
		AND a.idempleado = b.idempleado
		AND a.idnivel IN ( 0, 6, 7, 8, 9, 10 ) order by 1;
	
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
	DECLARE CONTINUE HANDLER FOR 1062 SET llaveDuplicada = 1;
	
	OPEN cursorParticipantes;
		read_loop: LOOP
			FETCH cursorParticipantes INTO rfcDocente;
			
			IF done THEN
				LEAVE read_loop;
			END IF;
			
			INSERT INTO participantes (rfc, anio) VALUES (rfcDocente, (select max(anio) from evaluacion));
			
		END LOOP;
	CLOSE cursorParticipantes;
	
END $$
DELIMITER ;
