BEGIN

	DECLARE idDebtor,countD, idCity, countC, idCampaig, countCa, idCampaigDebtor, countCD integer;
	

    SELECT id, count(id) INTO idDebtor, countD FROM tbl_debtors WHERE code = OLD.number and idCustomers = OLD.idCustomer LIMIT 1;
    SELECT id, count(id) INTO idCampaig, countCa FROM tbl_campaigns WHERE idCustomer = OLD.idCustomer LIMIT 1;
        
    IF(countD = 0) THEN

        SELECT id, count(id) INTO idCity, countC FROM tbl_cities WHERE UPPER(name) = UPPER(OLD.city) LIMIT 1;

        INSERT INTO `tbl_debtors`(`idCustomers`, `idDebtorsState`, `idTypeDocument`, `idCity`, `is_legal`, `code`, `name`, `address`, `phone`, `email`) 
        VALUES (OLD.idCustomer,9,IF(OLD.type_document = 'NIT', 1, 2),IF(countC > 0,idCity,525),0,OLD.number,OLD.name,OLD.address,OLD.phone,OLD.email);

        SELECT id, count(id) INTO idDebtor, countD FROM tbl_debtors WHERE code = OLD.number and idCustomers = OLD.idCustomer LIMIT 1;

    END IF;

    IF(countD > 0) THEN
        
        INSERT INTO `tbl_debtors_obligations`(`idDebtor`, `duedate`, `expeditionDate`, `description`, `capital`) 
        VALUES (idDebtor,OLD.expiration_date,OLD.expiration_date,OLD.comments,OLD.capital);

    END IF;

    SELECT count(id) INTO countCD FROM tbl_campaigns_debtors WHERE (idCampaigns = idCampaig AND idDebtor = idDebtor LIMIT 1;

    IF(countCD = 0) THEN
        
        INSERT INTO `tbl_campaigns_debtors`(`idCampaigns`, `idDebtor`) 
        VALUES (idCampaig,idDebtor);

    END IF;

END