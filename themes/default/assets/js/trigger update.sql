DELIMITER $$

CREATE
    /*[DEFINER = { user | CURRENT_USER }]*/
    TRIGGER tbl_tempo_demographic_after_update AFTER UPDATE
    ON tbl_tempo_demographic
	
    FOR EACH ROW BEGIN
    
    
	DECLARE idDebtor,countD,idCity,countC,idDebtorDemographic,countDD,countV INTEGER;
	DECLARE gender,mState,occupation,tDocument,education,dependents,age,stratus,housing,tcontract,income,payment,labor,contractT INTEGER;
	/*declare income,payment,labor,contractTerm varchar (255);*/
		
	    /*Especifica si existen deudores con el numero de documento*/
	    SELECT id, COUNT(id) INTO idDebtor, countD FROM tbl_debtors WHERE CODE = OLD.number AND idCustomers = OLD.idCustomer LIMIT 1;
	    
		
	    IF(countD > 0) THEN
	    
		SELECT id,COUNT(id) INTO gender, countV FROM tbl_genders WHERE NAME = OLD.gender LIMIT 1;	        
		SET gender = IF(countV > 0, gender, 0);
		
		SELECT id, COUNT(id) INTO mState, countV FROM tbl_marital_states WHERE NAME = OLD.marital_state LIMIT 1;
		SET mState = IF(countV > 0, mState, 0);
		
		SELECT id, COUNT(id) INTO occupation, countV FROM tbl_occupations WHERE NAME = OLD.occupation LIMIT 1;
		SET occupation = IF(countV > 0, occupation, 0);
		
		SELECT id, COUNT(id) INTO education, countV FROM tbl_type_education_levels WHERE NAME = OLD.occupation LIMIT 1;
		SET education = IF(countV > 0, education, 0);
		
		SELECT id, COUNT(id) INTO stratus, countV FROM tbl_type_social_stratus WHERE NAME = OLD.social_stratus LIMIT 1;
		SET stratus = IF(countV > 0, stratus, 0);
		
		SELECT id, COUNT(id) INTO housing, countV FROM tbl_type_housing WHERE NAME = OLD.social_stratus LIMIT 1;
		SET housing = IF(countV > 0, housing, 0);
		
		SELECT id, COUNT(id) INTO tcontract, countV FROM tbl_type_contract WHERE NAME = OLD.type_contract LIMIT 1;
		SET tcontract = IF(countV > 0, tcontract, 0);
		
		
		SET income = IF(OLD.income_legal IS NOT NULL OR OLD.income_legal <> "",OLD.income_legal,0);		
		/*SET dependents = IF(OLD.dependents IS NOT NULL OR OLD.dependents <> "",OLD.dependents,NULL); 
		SET payment = IF(OLD.payment_capacity IS NOT NULL OR OLD.payment_capacity <> "",OLD.payment_capacity,NULL);
		SET age = IF(OLD.age IS NOT NULL OR OLD.age <> "",OLD.age,NULL);
		SET labor = IF(OLD.labor_old IS NOT NULL OR OLD.labor_old <> "",OLD.labor_old,NULL);	
		SET contractT = IF(OLD.contract_term IS NOT NULL OR OLD.contract_term <> "",OLD.contract_term,NULL); */
		
		UPDATE tbl_links_help SET link = CONCAT('INSERT INTO tbl_debtors_demographics
			(idDebtor,idGender,idMaritalState,idOccupation,idTypeDocument,incomeLegal,idTypeEducationLevel,dependents,paymentCapacity,age,idTypeSocialStratus,idTypeHousing,laborOld,idTypeContract,contractTerm)
			VALUES (',idDebtor,',',gender,',',mState,',',occupation,',',income,');') 
			WHERE id = 1;
	    
		
		/*Especifica si existen datos del deudor en debtors_demographics*/
		/*SELECT id, COUNT(id) INTO idDebtorDemographic, countDD FROM tbl_debtors_demographics WHERE idDebtor = idDebtor LIMIT 1;
		SELECT id, COUNT(id) INTO idCity, countC FROM tbl_cities WHERE UPPER(NAME) = UPPER(IF(OLD.city IS NULL OR OLD.city = "",'',OLD.city)) LIMIT 1; 
	    
		UPDATE tbl_debtors SET 
		email = IF(OLD.email IS NULL OR OLD.email = "",OLD.email,NULL),
		neighborhood = IF(OLD.neighborhood IS NULL OR OLD.neighborhood = "",OLD.neighborhood,NULL),
		phone = IF(OLD.phone IS NULL OR OLD.phone = "",OLD.phone,NULL),
		mobile = IF(OLD.mobile IS NULL OR OLD.email = "",OLD.mobile,NULL), 
		idCity = IF(countC > 0,idCity,525)
		WHERE id = idDebtor;
		
		IF(countDD = 0) THEN
		
			INSERT INTO tbl_debtors_demographics
			(idDebtor,idGender,idMaritalState,idOccupation,idTypeDocument,idTypeIncomeLegal,idTypeEducationLevel,idTypeDependents,idTypePaymentCapacity,idTypeAge,idTypeSocialStratus,idTypeHousing,idTypeLaborOld,idTypeContract,idTypeContractTerm)
			VALUES (idDebtor,gender,mState,occupation,tDocument,income,education,dependents,payment,age,stratus,housing,labor,tcontract,contractTerm);
			INSERT INTO tbl_debtors_demographics
			(idDebtor,idGender,idMaritalState,idOccupation,idTypeDocument,incomeLegal)
			iNSERT INTO tbl_debtors_demographics
			(idDebtor,idGender,idMaritalState,idOccupation,idTypeDocument,incomeLegal,idTypeEducationLevel,dependents,paymentCapacity,age,idTypeSocialStratus,idTypeHousing,laborOld,idTypeContract,contractTerm)
			VALUES (idDebtor,gender,mState,occupation,tDocument,1,education,1,1,1,stratus,housing,1,tcontract,1);
			
		    
	        END IF;
	    
		IF(countDD > 0) THEN
		
		
			UPDATE tbl_debtors_demographics
			SET idGender = IF(OLD.gender IS NULL OR OLD.gender <> "",(SELECT id FROM tbl_genders WHERE NAME = OLD.gender),NULL),
			idMaritalState = IF(OLD.marital_state IS NULL OR OLD.marital_state <> "",(SELECT id FROM tbl_marital_states WHERE NAME = OLD.marital_state),NULL),
			idOccupation = IF(OLD.occupation IS NULL OR OLD.occupation <> "",(SELECT id FROM tbl_occupations WHERE NAME = OLD.occupation),NULL),
			idTypeDocument = (SELECT idTypeDocument FROM tbl_debtors WHERE id = idDebtor),
			idTypeIncomeLegal = IF(OLD.income_legal IS NOT NULL OR OLD.income_legal <> "",(SELECT id FROM tbl_type_income_legal WHERE OLD.income_legal BETWEEN `from` AND `to` LIMIT 1),NULL),
			idTypeEducationLevel = IF(OLD.education_level IS NULL OR OLD.education_level <> "",(SELECT id FROM tbl_type_education_levels WHERE NAME = OLD.education_level),NULL),
			idTypeDependents = IF(OLD.dependents IS NOT NULL OR OLD.dependents <> "",(SELECT id FROM tbl_type_dependents WHERE OLD.dependents BETWEEN `from` AND `to` LIMIT 1),NULL), 
			idTypeCapacity = IF(OLD.payment_capacity IS NOT NULL OR OLD.payment_capacity <> "",(SELECT id FROM tbl_type_payment_capacity WHERE OLD.payment_capacity BETWEEN `from` AND `to` LIMIT 1),NULL), 
			idTypeAge = IF(OLD.age IS NOT NULL OR OLD.age <> "",(SELECT id FROM tbl_type_age WHERE OLD.age BETWEEN `from` AND `to` LIMIT 1),NULL),
			idTypeSocialStratus = IF(OLD.social_stratus IS NULL OR OLD.social_stratus <> "",(SELECT id FROM tbl_type_social_stratus WHERE NAME = OLD.social_stratus),NULL),
			idTypeHousing = IF(OLD.type_housing IS NULL OR OLD.type_housing <> "",(SELECT id FROM tbl_type_housing WHERE NAME = OLD.type_housing),NULL),
			idTypeLaborOld = IF(OLD.labor_old IS NOT NULL OR OLD.labor_old <> "",(SELECT id FROM tbl_type_labor_old WHERE OLD.labor_old BETWEEN `from` AND `to` LIMIT 1),NULL),
			idTypeContract = IF(OLD.type_contract IS NULL OR OLD.type_contract <> "",(SELECT id FROM tbl_type_contract WHERE NAME = OLD.type_contract),NULL),
			idTypeContractTerm = IF(OLD.contract_term IS NOT NULL OR OLD.contract_term <> "",(SELECT id FROM tbl_type_contract_term WHERE OLD.contract_term BETWEEN `from` AND `to` LIMIT 1),NULL)
			WHERE idDebtor = idDebtor;
			
		END IF;*/

	    END IF;

    END$$

DELIMITER ;