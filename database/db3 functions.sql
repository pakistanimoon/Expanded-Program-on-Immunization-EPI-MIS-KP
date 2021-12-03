--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

--
-- Name: adjustmentname(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION adjustmentname(amcode integer) RETURNS text
    LANGUAGE plpgsql
    AS $$ DECLARE
     amname text;
   BEGIN
    SELECT transaction_type_name into amname from epi_transaction_types where pk_id=amcode;
   RETURN amname;
   END$$;


ALTER FUNCTION public.adjustmentname(amcode integer) OWNER TO postgres;

--
-- Name: area_name(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION area_name(recid_a integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
        areaname text;
    BEGIN
	SELECT area_name into areaname from situation_analysis_db where recid=recid_a;
        RETURN areaname;
END;
  $$;


ALTER FUNCTION public.area_name(recid_a integer) OWNER TO postgres;

--
-- Name: assetname(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION assetname(ascode integer) RETURNS text
    LANGUAGE plpgsql
    AS $$ DECLARE
     asname text;
   BEGIN
    SELECT asset_type_name into asname from epi_cc_asset_types where pk_id=ascode;
   RETURN asname;
   END$$;


ALTER FUNCTION public.assetname(ascode integer) OWNER TO postgres;

--
-- Name: assettypename_usingccmid(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION assettypename_usingccmid(ccmid integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
     asname text;
   BEGIN
    SELECT assetname(ccm_sub_asset_type_id) into asname from epi_cc_coldchain_main where asset_id=ccmid;
   RETURN asname;
   END$$;


ALTER FUNCTION public.assettypename_usingccmid(ccmid integer) OWNER TO postgres;

--
-- Name: bankname(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION bankname(bid text) RETURNS text
    LANGUAGE plpgsql
    AS $$  DECLARE
        bank text;
    BEGIN
	SELECT bankname into bank from bankinfo where bankid=bid;
        RETURN bank;
    END;
  $$;


ALTER FUNCTION public.bankname(bid text) OWNER TO postgres;

--
-- Name: case_investigation_db_delete(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION case_investigation_db_delete() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
rowexist boolean;
columnname text;

BEGIN
IF OLD.patient_name = '0' THEN
columnname := 'fwk'||substring(OLD.fweek from 6 for 2);
ELSE
columnname := 'mwk'||substring(OLD.fweek from 6 for 2);
END IF;

select exists(select * from epidcount_db WHERE case_type=OLD.case_type AND year=substring(OLD.fweek from 1 for 4) AND distcode=OLD.distcode AND procode=OLD.procode) into rowexist;
IF rowexist = FALSE THEN
	EXECUTE 'INSERT INTO epidcount_db (year,'||columnname||',procode,distcode,case_type) values ('''||substring(OLD.fweek from 1 for 4)||''',0,'''||OLD.procode||''','''||OLD.distcode||''','''||OLD.case_type||''')';
ELSEIF rowexist = TRUE THEN
        EXECUTE 'UPDATE epidcount_db set '||columnname||' = '||columnname||'-1 WHERE year = '''||substring(OLD.fweek from 1 for 4)||''' AND distcode = '''||OLD.distcode||''' AND procode = '''||OLD.procode||''' AND case_type = '''||OLD.case_type||'''';
END IF;
 RETURN NEW;
END;$$;


ALTER FUNCTION public.case_investigation_db_delete() OWNER TO postgres;

--
-- Name: case_investigation_db_insert(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION case_investigation_db_insert() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
rowexist boolean;
columnname text;

BEGIN
IF NEW.patient_gender = '0' THEN
columnname := 'fwk'||substring(NEW.fweek from 6 for 2);
ELSE
columnname := 'mwk'||substring(NEW.fweek from 6 for 2);
END IF;

select exists(select * from epidcount_db WHERE case_type=NEW.case_type AND year=substring(NEW.fweek from 1 for 4) AND distcode=NEW.distcode AND procode=NEW.procode) into rowexist;
IF rowexist = FALSE THEN
	EXECUTE 'INSERT INTO epidcount_db (year,'||columnname||',procode,distcode,case_type) values ('''||substring(NEW.fweek from 1 for 4)||''',1,'''||NEW.procode||''','''||NEW.distcode||''','''||NEW.case_type||''')';
ELSEIF rowexist = TRUE THEN
        EXECUTE 'UPDATE epidcount_db set '||columnname||' = '||columnname||'+1 WHERE year = '''||substring(NEW.fweek from 1 for 4)||''' AND distcode = '''||NEW.distcode||''' AND procode = '''||NEW.procode||''' AND case_type = '''||NEW.case_type||'''';
END IF;
 RETURN NEW;
END;$$;


ALTER FUNCTION public.case_investigation_db_insert() OWNER TO postgres;

--
-- Name: case_investigation_db_update(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION case_investigation_db_update() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
rowexist boolean;
newcolumnname text;
oldcolumnname text;

BEGIN
IF NEW.patient_gender = '0' THEN
newcolumnname := 'fwk'||substring(NEW.fweek from 6 for 2);
oldcolumnname := 'fwk'||substring(OLD.fweek from 6 for 2);
ELSE
newcolumnname := 'mwk'||substring(NEW.fweek from 6 for 2);
oldcolumnname := 'mwk'||substring(OLD.fweek from 6 for 2);
END IF;

select exists(select * from epidcount_db WHERE case_type=OLD.case_type AND year=substring(OLD.fweek from 1 for 4) AND distcode=OLD.distcode AND procode=OLD.procode) into rowexist;
IF rowexist = FALSE THEN
	EXECUTE 'INSERT INTO epidcount_db (year,'||newcolumnname||',procode,distcode,case_type) values ('''||substring(NEW.fweek from 1 for 4)||''',1,'''||NEW.procode||''','''||NEW.distcode||''','''||NEW.case_type||''')';
ELSEIF rowexist = TRUE THEN
        IF NEW.fweek <> OLD.fweek AND substring(NEW.fweek from 1 for 4) = substring(OLD.fweek from 1 for 4) THEN
            EXECUTE 'UPDATE epidcount_db SET '||newcolumnname||' = '||newcolumnname||'+1,'||oldcolumnname||' = '||oldcolumnname||'-1 WHERE year = '''||substring(OLD.fweek from 1 for 4)||''' AND distcode = '''||OLD.distcode||''' AND procode = '''||OLD.procode||''' AND case_type = '''||OLD.case_type||'''';
        END IF;
END IF;
 RETURN NEW;
END;$$;


ALTER FUNCTION public.case_investigation_db_update() OWNER TO postgres;

--
-- Name: case_reported(character varying, character varying, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION case_reported(fweekk character varying, facodee character varying, tablename text) RETURNS character varying
    LANGUAGE plpgsql
    AS $$DECLARE
        totpop  character varying;
    BEGIN
       EXECUTE 'SELECT CASE(select EXISTS(select count(case_reported) from ' || quote_ident(tablename) || ' where fweek = ''' || fweekk || ''' and facode = ''' || facodee|| ''' HAVING count(case_reported) > 0 ) )  
        WHEN TRUE 
              THEN (select CASE(count(case_reported)) 
                        WHEN 1
                             THEN 
                                 (select CASE(case_reported)
                                       WHEN 1
                                             THEN 1::TEXT
                                       WHEN 0
                                             THEN ''zr''::TEXT
                                       END
                                 from ' || quote_ident(tablename) || ' where fweek = ''' || fweekk || ''' and facode = ''' || facodee|| ''')
                             ELSE 
                                 count(case_reported)::TEXT 
                        END 
                    from ' || quote_ident(tablename) || ' where fweek = ''' || fweekk || ''' and facode = ''' || facodee|| ''')     
              ELSE 0::TEXT END' into totpop;
    RETURN totpop;
    END;
$$;


ALTER FUNCTION public.case_reported(fweekk character varying, facodee character varying, tablename text) OWNER TO postgres;

--
-- Name: caseafpepidcount_master_insert(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION caseafpepidcount_master_insert() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
rowexist boolean;
colum1 text;
colum1value text;
casetype text;
dosesreceived integer;
crossnotified integer;



BEGIN
colum1value := 0;
casetype := 'Afp';
crossnotified := NEW.cross_notified;
 
IF NEW.doses_received > 2 THEN
dosesreceived := 99 ;
ELSE
dosesreceived := NEW.doses_received;
END IF;

IF NEW.age_months >= 0 AND NEW.age_months < 9 THEN
colum1 := 'lessthan9months';

ELSEIF NEW.age_months >= 9 and NEW.age_months < 24 THEN
colum1 := 'age9to24months';

ELSEIF NEW.age_months >= 24 and NEW.age_months < 60 THEN
colum1 := 'age24to60months';

ELSEIF NEW.age_months >= 60 and NEW.age_months < 120 THEN
colum1 := 'age60to120months';

ELSEIF NEW.age_months >= 120 and NEW.age_months < 180 THEN
colum1 := 'age120to180months';

ELSEIF NEW.age_months >= 180 THEN
colum1 := 'greaterthan180months';

ELSEIF NEW.age_months is NULL THEN
colum1 := 'unknown';

END IF;
 
 IF NEW.cross_notified  = 1 THEN
 
 ELSE       
     select exists(select * from caseepidcount_master WHERE dosenumber=dosesreceived  AND gender::text=NEW.patient_gender AND case_type=casetype AND selected_week=NEW.week AND year=NEW.year  AND distcode=NEW.distcode AND procode=NEW.procode) into rowexist;
IF rowexist = FALSE THEN
	EXECUTE 'INSERT INTO caseepidcount_master (procode,distcode,case_type,dosenumber,'||colum1||',gender,year,selected_week) values ('''||NEW.procode||''','''||NEW.distcode||''','''||casetype||''','||dosesreceived||',1,'''||NEW.patient_gender||''','''||NEW.year||''','''||NEW.week||''')';

ELSEIF rowexist = TRUE THEN
        EXECUTE 'UPDATE caseepidcount_master set '||colum1||' = '||colum1||'+1 WHERE  gender = '''||NEW.patient_gender::text||''' AND case_type = '''||casetype||''' AND dosenumber = '||dosesreceived||' AND selected_week = '''||NEW.week||''' AND year = '''||NEW.year||'''  AND distcode = '''||NEW.distcode||''' AND procode = '''||NEW.procode||''' ';
 
END IF;

END IF;

 RETURN NEW;
END;
$$;


ALTER FUNCTION public.caseafpepidcount_master_insert() OWNER TO postgres;

--
-- Name: caseafpepidcount_master_update(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION caseafpepidcount_master_update() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
notequalrowexist boolean;
equalrowexist boolean;
casetype text;
dosesreceived integer;
olddosesreceived integer;

newcolum1 text;

newcolum1value text;


oldcolum1 text;

oldcolum1value text;


BEGIN
newcolum1value := 0;
casetype:= 'Afp';
oldcolum1value := 0;

IF NEW.doses_received > 2 THEN
dosesreceived := 99 ;
ELSE
dosesreceived := NEW.doses_received;
END IF;
IF OLD.doses_received > 2 THEN
olddosesreceived := 99 ;
ELSE
olddosesreceived := OLD.doses_received;
END IF;


IF NEW.age_months >= 0 AND NEW.age_months < 9 THEN
newcolum1 := 'lessthan9months';

ELSEIF NEW.age_months >= 9 and NEW.age_months < 24 THEN
newcolum1 := 'age9to24months';

ELSEIF NEW.age_months >= 24 and NEW.age_months < 60 THEN
newcolum1 := 'age24to60months';

ELSEIF NEW.age_months >= 60 and NEW.age_months < 120 THEN
newcolum1 := 'age60to120months';

ELSEIF NEW.age_months >= 120 and NEW.age_months < 180 THEN
newcolum1 := 'age120to180months';

ELSEIF NEW.age_months >= 180 THEN
newcolum1 := 'greaterthan180months';

ELSEIF NEW.age_months is NULL THEN
newcolum1 := 'unknown';

END IF;

IF OLD.age_months >= 0 AND OLD.age_months < 9 THEN
oldcolum1 := 'lessthan9months';

ELSEIF OLD.age_months >= 9 and NEW.age_months < 24 THEN
oldcolum1 := 'age9to24months';

ELSEIF OLD.age_months >= 24 and NEW.age_months < 60 THEN
oldcolum1 := 'age24to60months';

ELSEIF OLD.age_months >= 60 and NEW.age_months < 120 THEN
oldcolum1 := 'age60to120months';

ELSEIF OLD.age_months >= 120 and NEW.age_months < 180 THEN
oldcolum1 := 'age120to180months';

ELSEIF OLD.age_months >= 180 THEN
oldcolum1 := 'greaterthan180months';

ELSEIF OLD.age_months is NULL THEN
oldcolum1 := 'unknown';

END IF;

IF NEW.cross_notified <> 1 OR NEW.approval_status = 'Approved' THEN
      
      IF NEW.procode <> OLD.procode OR NEW.distcode <> OLD.distcode OR NEW.patient_gender <> OLD.patient_gender OR NEW.year <> OLD.year OR NEW.week <> OLD.week  OR dosesreceived <> olddosesreceived THEN
            
         select exists(select * from caseepidcount_master WHERE dosenumber=dosesreceived AND gender=NEW.patient_gender::character varying AND case_type=casetype AND selected_week=NEW.week AND year=NEW.year  AND distcode=NEW.distcode AND procode=NEW.procode) into notequalrowexist;
      IF notequalrowexist= TRUE THEN
         EXECUTE 'UPDATE caseepidcount_master set '||newcolum1||' = '||newcolum1||'+1 WHERE  gender = '''||NEW.patient_gender::character varying||''' AND case_type = '''||casetype||'''  AND dosenumber = '||dosesreceived||' AND selected_week = '''||NEW.week||''' AND year = '''||NEW.year||'''  AND distcode = '''||NEW.distcode||''' AND procode = '''||NEW .procode||''' ';
         EXECUTE 'UPDATE caseepidcount_master set '||oldcolum1||' = '||oldcolum1||'-1 WHERE  gender = '''||OLD.patient_gender::character varying||''' AND case_type = '''||casetype||''' AND dosenumber = '||olddosesreceived||' AND selected_week = '''||OLD.week||''' AND year = '''||OLD.year||'''  AND distcode = '''||OLD.distcode||''' AND procode = '''||OLD.procode||''' ';
      ELSEIF notequalrowexist= FALSE THEN
	 EXECUTE 'INSERT INTO caseepidcount_master (procode,distcode,case_type,dosenumber,'||newcolum1||',gender,year,selected_week) values ('''||NEW.procode||''','''||NEW.distcode||''','''||casetype||''','||dosesreceived||',1,'''||NEW.patient_gender||''','''||NEW.year||''','''||NEW.week||''')';

      END IF;
ELSEIF  NEW.procode = OLD.procode AND NEW.distcode = OLD.distcode AND NEW.patient_gender = OLD.patient_gender AND NEW.year = OLD.year AND NEW.week = OLD.week  AND dosesreceived = olddosesreceived THEN 
         
      select exists(select * from caseepidcount_master WHERE dosenumber=dosesreceived AND gender=NEW.patient_gender::character varying AND case_type=casetype AND selected_week=NEW.week AND year=NEW.year  AND distcode=NEW.distcode AND procode=NEW.procode) into equalrowexist;
      IF equalrowexist= TRUE THEN

         EXECUTE 'UPDATE caseepidcount_master set '||newcolum1||' = '||newcolum1||'+1 WHERE  gender= '''||NEW.patient_gender::character varying||''' AND case_type = '''||casetype||''' AND dosenumber = '||dosesreceived||' AND selected_week = '''||NEW.week||''' AND year = '''||NEW.year||'''  AND distcode = '''||NEW.distcode||''' AND procode = '''||NEW .procode||'''  ';
         EXECUTE 'UPDATE caseepidcount_master set '||oldcolum1||' = '||oldcolum1||'-1 WHERE  gender = '''||OLD.patient_gender::character varying||''' AND case_type = '''||casetype||''' AND dosenumber = '||olddosesreceived||' AND selected_week = '''||OLD.week||''' AND year = '''||OLD.year||'''  AND distcode = '''||OLD.distcode||''' AND procode = '''||OLD .procode||'''  ';
      ELSEIF equalrowexist= FALSE THEN

         EXECUTE 'INSERT INTO caseepidcount_master (procode,distcode,case_type,dosenumber,'||newcolum1||',gender,year,selected_week) values ('''||NEW.procode||''','''||NEW.distcode||''','''||casetype||''','||dosesreceived||',1,'''||NEW.patient_gender||''','''||NEW.year||''','''||NEW.week||''')';  
      END IF;


END IF;
END IF;
 RETURN NEW;
END;
$$;


ALTER FUNCTION public.caseafpepidcount_master_update() OWNER TO postgres;

--
-- Name: caseepidcount_master_insert(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION caseepidcount_master_insert() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
	rowexist boolean;
	colum1 text;
	colum2 text;
	colum3 text;
	colum4 text;
	colum1value text;
	colum2value text;
	colum3value text;
	colum4value text;

	BEGIN
		colum1value := 0;
		colum2value := 0;
		colum3value := 0;
		colum4value := 0;

		IF  NEW.specimen_result = 'Positive'  THEN
			colum3value := 1;
		ELSEIF NEW.specimen_result = 'Positive Measles' THEN
			colum3value := 1;
		ELSEIF NEW.specimen_result = 'Positive Rubella' THEN
			colum4value := 1;
		END IF;

		IF NEW.type_specimen <> 'Not Collected' THEN
			colum2value := 1;
		END IF;

		IF NEW.age_months >= 0 AND NEW.age_months < 9 THEN
			colum1 := 'lessthan9months';
			colum2 := 'lessthan9months_samplecollected';
			colum3 := 'lessthan9months_result_positive';
			colum4 := 'lessthan9months_result_positive_rubella';
		ELSEIF NEW.age_months >= 9 and NEW.age_months < 24 THEN
			colum1 := 'age9to24months';
			colum2 := 'age9to24months_samplecollected';
			colum3 := 'age9to24months_result_positive';
			colum4 := 'age9to24months_result_positive_rubella';
		ELSEIF NEW.age_months >= 24 and NEW.age_months < 60 THEN
			colum1 := 'age24to60months';
			colum2 := 'age24to60months_samplecollected';
			colum3 := 'age24to60months_result_positive';
			colum4 := 'age24to60months_result_positive_rubella';
		ELSEIF NEW.age_months >= 60 and NEW.age_months < 120 THEN
			colum1 := 'age60to120months';
			colum2 := 'age60to120months_samplecollected';
			colum3 := 'age60to120months_result_positive';
			colum4 := 'age60to120months_result_positive_rubella';
		ELSEIF NEW.age_months >= 120 and NEW.age_months < 180 THEN
			colum1 := 'age120to180months';
			colum2 := 'age120to180months_samplecollected';
			colum3 := 'age120to180months_result_positive';
			colum4 := 'age120to180months_result_positive_rubella';
		ELSEIF NEW.age_months >= 180 THEN
			colum1 := 'greaterthan180months';
			colum2 := 'greaterthan180months_samplecollected';
			colum3 := 'greaterthan180months_result_positive';
			colum4 := 'greaterthan180months_result_positive_rubella';
		ELSEIF NEW.age_months is NULL THEN
			colum1 := 'unknown';
			colum2 := 'unknown_samplecollected';
			colum3 := 'unknown_result_positive';
			colum4 := 'unknown_result_positive_rubella';
		END IF;
               
               IF NEW.cross_notified = 1 THEN
--donothing
ELSE

		select exists(select * from caseepidcount_master WHERE dosenumber=NEW.doses_received AND gender::character varying=NEW.patient_gender AND case_type=NEW.case_type AND selected_week=NEW.week AND year=NEW.year  AND distcode=NEW.distcode AND procode=NEW.procode) into rowexist;
		IF rowexist = FALSE THEN

			EXECUTE 'INSERT INTO caseepidcount_master (procode,distcode,case_type,dosenumber,'||colum1||','||colum2||','||colum3||','||colum4||',gender,year,selected_week) values ('''||NEW.procode||''','''||NEW.distcode||''','''||NEW.case_type||''','''||NEW.doses_received||''',1,'''||colum2value||''','''||colum3value||''','''||colum4value||''','''||NEW.patient_gender||''','''||NEW.year||''','''||NEW.week||''')';

		ELSEIF rowexist = TRUE THEN
				EXECUTE 'UPDATE caseepidcount_master set '||colum1||' = '||colum1||'+1,'||colum2||' = '||colum2||'+'||colum2value||','||colum3||' = '||colum3||'+'||colum3value||','||colum4||' = '||colum4||'+'||colum4value||' WHERE  gender::character varying = '''||NEW.patient_gender||''' AND case_type = '''||NEW.case_type||''' AND dosenumber = '''||NEW.doses_received||''' AND selected_week = '''||NEW.week||''' AND year = '''||NEW.year||'''  AND distcode = '''||NEW.distcode||''' AND procode = '''||NEW.procode||''' ';

		END IF;
               END IF;
	RETURN NEW;
END;$$;


ALTER FUNCTION public.caseepidcount_master_insert() OWNER TO postgres;

--
-- Name: caseepidcount_master_update(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION caseepidcount_master_update() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
		notequalrowexist boolean;
		equalrowexist boolean;

		newcolum1 text;
		newcolum2 text;
		newcolum3 text;
		newcolum4 text;
		newcolum1value text;
		newcolum2value text;
		newcolum3value text;
		newcolum4value text;

		oldcolum1 text;
		oldcolum2 text;
		oldcolum3 text;
		oldcolum4 text;
		oldcolum1value text;
		oldcolum2value text;
		oldcolum3value text;
		oldcolum4value text;

		BEGIN
			newcolum1value := 0;
			newcolum2value := 0;
			newcolum3value := 0;
			newcolum4value := 0;
			oldcolum1value := 0;
			oldcolum2value := 0;
			oldcolum3value := 0;
			oldcolum4value := 0;

			IF  NEW.specimen_result = 'Positive'  THEN
				newcolum3value := 1;
			ELSEIF NEW.specimen_result = 'Positive Measles' THEN
				newcolum3value := 1;
			ELSEIF NEW.specimen_result = 'Positive Rubella' THEN
				newcolum4value := 1;
			END IF;

			IF  OLD.specimen_result = 'Positive'  THEN
				oldcolum3value := 1;
			ELSEIF OLD.specimen_result = 'Positive Measles' THEN
				oldcolum3value := 1;
			ELSEIF OLD.specimen_result = 'Positive Rubella' THEN
				oldcolum4value := 1;
			END IF;


			IF NEW.type_specimen <> 'Not Collected' THEN
				newcolum2value := 1;
			END IF;

			IF OLD.type_specimen <> 'Not Collected' THEN
				oldcolum2value := 1;
			END IF;

			IF NEW.age_months >= 0 AND NEW.age_months < 9 THEN
				newcolum1 := 'lessthan9months';
				newcolum2 := 'lessthan9months_samplecollected';
				newcolum3 := 'lessthan9months_result_positive';
				newcolum4 := 'lessthan9months_result_positive_rubella';
			ELSEIF NEW.age_months >= 9 and NEW.age_months < 24 THEN
				newcolum1 := 'age9to24months';
				newcolum2 := 'age9to24months_samplecollected';
				newcolum3 := 'age9to24months_result_positive';
				newcolum4 := 'age9to24months_result_positive_rubella';
			ELSEIF NEW.age_months >= 24 and NEW.age_months < 60 THEN
				newcolum1 := 'age24to60months';
				newcolum2 := 'age24to60months_samplecollected';
				newcolum3 := 'age24to60months_result_positive';
				newcolum4 := 'age24to60months_result_positive_rubella';
			ELSEIF NEW.age_months >= 60 and NEW.age_months < 120 THEN
				newcolum1 := 'age60to120months';
				newcolum2 := 'age60to120months_samplecollected';
				newcolum3 := 'age60to120months_result_positive';
				newcolum4 := 'age60to120months_result_positive_rubella';
			ELSEIF NEW.age_months >= 120 and NEW.age_months < 180 THEN
				newcolum1 := 'age120to180months';
				newcolum2 := 'age120to180months_samplecollected';
				newcolum3 := 'age120to180months_result_positive';
				newcolum4 := 'age120to180months_result_positive_rubella';
			ELSEIF NEW.age_months >= 180 THEN
				newcolum1 := 'greaterthan180months';
				newcolum2 := 'greaterthan180months_samplecollected';
				newcolum3 := 'greaterthan180months_result_positive';
				newcolum4 := 'greaterthan180months_result_positive_rubella';
			ELSEIF NEW.age_months is NULL THEN
				newcolum1 := 'unknown';
				newcolum2 := 'unknown_samplecollected';
				newcolum3 := 'unknown_result_positive';
				newcolum4 := 'unknown_result_positive_rubella';
			END IF;

			IF OLD.age_months >= 0 AND OLD.age_months < 9 THEN
				oldcolum1 := 'lessthan9months';
				oldcolum2 := 'lessthan9months_samplecollected';
				oldcolum3 := 'lessthan9months_result_positive';
				oldcolum4 := 'lessthan9months_result_positive_rubella';
			ELSEIF OLD.age_months >= 9 and NEW.age_months < 24 THEN
				oldcolum1 := 'age9to24months';
				oldcolum2 := 'age9to24months_samplecollected';
				oldcolum3 := 'age9to24months_result_positive';
				oldcolum4 := 'age9to24months_result_positive_rubella';
			ELSEIF OLD.age_months >= 24 and NEW.age_months < 60 THEN
				oldcolum1 := 'age24to60months';
				oldcolum2 := 'age24to60months_samplecollected';
				oldcolum3 := 'age24to60months_result_positive';
				oldcolum4 := 'age24to60months_result_positive_rubella';
			ELSEIF OLD.age_months >= 60 and NEW.age_months < 120 THEN
				oldcolum1 := 'age60to120months';
				oldcolum2 := 'age60to120months_samplecollected';
				oldcolum3 := 'age60to120months_result_positive';
				oldcolum4 := 'age60to120months_result_positive_rubella';
			ELSEIF OLD.age_months >= 120 and NEW.age_months < 180 THEN
				oldcolum1 := 'age120to180months';
				oldcolum2 := 'age120to180months_samplecollected';
				oldcolum3 := 'age120to180months_result_positive';
				oldcolum4 := 'age120to180months_result_positive_rubella';
			ELSEIF OLD.age_months >= 180 THEN
				oldcolum1 := 'greaterthan180months';
				oldcolum2 := 'greaterthan180months_samplecollected';
				oldcolum3 := 'greaterthan180months_result_positive';
				oldcolum4 := 'greaterthan180months_result_positive_rubella';
			ELSEIF OLD.age_months is NULL THEN
				oldcolum1 := 'unknown';
				oldcolum2 := 'unknown_samplecollected';
				oldcolum3 := 'unknown_result_positive';
				oldcolum4 := 'unknown_result_positive_rubella';
			END IF;

                        IF NEW.cross_notified <> 1 OR NEW.approval_status = 'Approved' THEN


			IF NEW.procode <> OLD.procode OR NEW.distcode <> OLD.distcode OR NEW.patient_gender <> OLD.patient_gender OR NEW.year <> OLD.year OR NEW.week <> OLD.week OR NEW.case_type <> OLD.case_type OR NEW.doses_received <> OLD.doses_received THEN
				select exists(select * from caseepidcount_master WHERE dosenumber=NEW.doses_received AND gender::character varying=NEW.patient_gender AND case_type=NEW.case_type AND selected_week=NEW.week AND year=NEW.year  AND distcode=NEW.distcode AND procode=NEW.procode) into notequalrowexist;
			IF notequalrowexist= TRUE THEN
				EXECUTE 'UPDATE caseepidcount_master set '||newcolum1||' = '||newcolum1||'+1,'||newcolum2||' = '||newcolum2||'+'||newcolum2value||','||newcolum3||' = '||newcolum3||'+'||newcolum3value||','||newcolum4||' = '||newcolum4||'+'||newcolum4value||' WHERE  gender::character varying = '''||NEW.patient_gender||''' AND case_type = '''||NEW.case_type||''' AND dosenumber = '''||NEW.doses_received||''' AND selected_week = '''||NEW.week||''' AND year = '''||NEW.year||'''  AND distcode = '''||NEW.distcode||''' AND procode = '''||NEW .procode||''' ';
				EXECUTE 'UPDATE caseepidcount_master set '||oldcolum1||' = '||oldcolum1||'-1,'||oldcolum2||' = '||oldcolum2||'-'||oldcolum2value||','||oldcolum3||' = '||oldcolum3||'-'||oldcolum3value||','||oldcolum4||' = '||oldcolum4||'-'||oldcolum4value||' WHERE  gender::character varying = '''||OLD.patient_gender||''' AND case_type = '''||OLD.case_type||''' AND dosenumber = '''||OLD.doses_received||''' AND selected_week = '''||OLD.week||''' AND year = '''||OLD.year||'''  AND distcode = '''||OLD.distcode||''' AND procode = '''||OLD.procode||''' ';
			ELSEIF notequalrowexist= FALSE THEN
				EXECUTE 'INSERT INTO caseepidcount_master (procode,distcode,case_type,dosenumber,'||newcolum1||','||newcolum2||','||newcolum3||','||newcolum4||',gender,year,selected_week) values ('''||NEW.procode||''','''||NEW.distcode||''','''||NEW.case_type||''','''||NEW.doses_received||''',1,'''||newcolum2value||''','''||newcolum3value||''','''||newcolum4value||''','''||NEW.patient_gender||''','''||NEW.year||''','''||NEW.week||''')';

			END IF;

			ELSEIF  NEW.procode = OLD.procode AND NEW.distcode = OLD.distcode AND NEW.patient_gender = OLD.patient_gender AND NEW.year = OLD.year AND NEW.week = OLD.week AND NEW.case_type = OLD.case_type AND NEW.doses_received = OLD.doses_received THEN
				select exists(select * from caseepidcount_master WHERE dosenumber=NEW.doses_received AND gender::character varying=NEW.patient_gender AND case_type=NEW.case_type AND selected_week=NEW.week AND year=NEW.year  AND distcode=NEW.distcode AND procode=NEW.procode) into equalrowexist;
			IF equalrowexist= TRUE THEN
				EXECUTE 'UPDATE caseepidcount_master set '||newcolum1||' = '||newcolum1||'+1,'||newcolum2||' = '||newcolum2||'+'||newcolum2value||','||newcolum3||' = '||newcolum3||'+'||newcolum3value||','||newcolum4||' = '||newcolum4||'+'||newcolum4value||' WHERE  gender::character varying = '''||NEW.patient_gender||''' AND case_type = '''||NEW.case_type||''' AND dosenumber = '''||NEW.doses_received||''' AND selected_week = '''||NEW.week||''' AND year = '''||NEW.year||'''  AND distcode = '''||NEW.distcode||''' AND procode = '''||NEW .procode||'''  ';
				EXECUTE 'UPDATE caseepidcount_master set '||oldcolum1||' = '||oldcolum1||'-1,'||oldcolum2||' ='||oldcolum2||'-'||oldcolum2value||','||oldcolum3||' = '||oldcolum3||'-'||oldcolum3value||','||oldcolum4||' = '||oldcolum4||'-'||oldcolum4value||' WHERE  gender::character varying = '''||OLD.patient_gender||''' AND case_type = '''||OLD.case_type||''' AND dosenumber = '''||OLD.doses_received||''' AND selected_week = '''||OLD.week||''' AND year = '''||OLD.year||'''  AND distcode = '''||OLD.distcode||''' AND procode = '''||OLD .procode||'''  ';
			ELSEIF equalrowexist= FALSE THEN
				EXECUTE 'INSERT INTO caseepidcount_master (procode,distcode,case_type,dosenumber,'||newcolum1||','||newcolum2||','||newcolum3||','||newcolum4||',gender,year,selected_week) values ('''||NEW.procode||''','''||NEW.distcode||''','''||NEW.case_type||''','''||NEW.doses_received||''',1,'''||newcolum2value||''','''||newcolum3value||''','''||newcolum4value||''','''||NEW.patient_gender||''','''||NEW.year||''','''||NEW.week||''')';
			END IF;
       END IF;
      END IF;
	RETURN NEW;
END;$$;


ALTER FUNCTION public.caseepidcount_master_update() OWNER TO postgres;

--
-- Name: casenntepidcount_master_insert(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION casenntepidcount_master_insert() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
rowexist boolean;
colum1 text;
colum1value text;
casetype text;
dosesreceived integer;
newgender integer;

BEGIN
colum1value := 0;
casetype := 'Nnt';
 
IF NEW.doses_received > 2 THEN
dosesreceived := 99 ;
ELSE
dosesreceived := NEW.doses_received;
END IF;


 
IF NEW.gender = 'Male' THEN
newgender:= 1 ;
ELSE
newgender:= 0 ;
END IF;


IF NEW.age_months >= 0 AND NEW.age_months < 9 THEN
colum1 := 'lessthan9months';

ELSEIF NEW.age_months >= 9 and NEW.age_months < 24 THEN
colum1 := 'age9to24months';

ELSEIF NEW.age_months >= 24 and NEW.age_months < 60 THEN
colum1 := 'age24to60months';

ELSEIF NEW.age_months >= 60 and NEW.age_months < 120 THEN
colum1 := 'age60to120months';

ELSEIF NEW.age_months >= 120 and NEW.age_months < 180 THEN
colum1 := 'age120to180months';

ELSEIF NEW.age_months >= 180 THEN
colum1 := 'greaterthan180months';

ELSEIF NEW.age_months is NULL THEN
colum1 := 'unknown';

END IF;
 
 IF NEW.cross_notified  = 1 THEN
 --do nothing
 ELSE       
     select exists(select * from caseepidcount_master WHERE dosenumber=dosesreceived  AND gender=newgender::text AND case_type=casetype AND selected_week=NEW.week AND year=NEW.year::text  AND distcode=NEW.distcode AND procode=NEW.procode) into rowexist;
IF rowexist = FALSE THEN
	EXECUTE 'INSERT INTO caseepidcount_master (procode,distcode,case_type,dosenumber,'||colum1||',gender,year,selected_week) values ('''||NEW.procode||''','''||NEW.distcode||''','''||casetype||''','||dosesreceived||',1,'||newgender||','''||NEW.year||''','''||NEW.week||''')';

ELSEIF rowexist = TRUE THEN
        EXECUTE 'UPDATE caseepidcount_master set '||colum1||' = '||colum1||'+1 WHERE  gender::integer = '||newgender||' AND case_type = '''||casetype||''' AND dosenumber = '||dosesreceived||' AND selected_week = '''||NEW.week||''' AND year = '''||NEW.year::text||'''  AND distcode = '''||NEW.distcode||''' AND procode = '''||NEW.procode||''' ';
 
END IF;

END IF;

 RETURN NEW;
END;
$$;


ALTER FUNCTION public.casenntepidcount_master_insert() OWNER TO postgres;

--
-- Name: casenntepidcount_master_update(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION casenntepidcount_master_update() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
notequalrowexist boolean;
equalrowexist boolean;
casetype text;
dosesreceived integer;
olddosesreceived integer;
newgender integer;
oldgender integer;

newcolum1 text;

newcolum1value text;


oldcolum1 text;

oldcolum1value text;


BEGIN
newcolum1value := 0;
casetype:= 'Nnt';
oldcolum1value := 0;

IF NEW.doses_received > 2 THEN
dosesreceived := 99 ;
ELSE
dosesreceived := NEW.doses_received;
END IF;
IF OLD.doses_received > 2 THEN
olddosesreceived := 99 ;
ELSE
olddosesreceived := OLD.doses_received;
END IF;

IF NEW.gender ='Male' THEN
newgender := 1;
ELSE
newgender := 0;
END IF;
IF OLD.gender ='Male'  THEN
oldgender:= 1;
ELSE
oldgender:= 0;
END IF;




IF NEW.age_months >= 0 AND NEW.age_months < 9 THEN
newcolum1 := 'lessthan9months';

ELSEIF NEW.age_months >= 9 and NEW.age_months < 24 THEN
newcolum1 := 'age9to24months';

ELSEIF NEW.age_months >= 24 and NEW.age_months < 60 THEN
newcolum1 := 'age24to60months';

ELSEIF NEW.age_months >= 60 and NEW.age_months < 120 THEN
newcolum1 := 'age60to120months';

ELSEIF NEW.age_months >= 120 and NEW.age_months < 180 THEN
newcolum1 := 'age120to180months';

ELSEIF NEW.age_months >= 180 THEN
newcolum1 := 'greaterthan180months';

ELSEIF NEW.age_months is NULL THEN
newcolum1 := 'unknown';

END IF;

IF OLD.age_months >= 0 AND OLD.age_months < 9 THEN
oldcolum1 := 'lessthan9months';

ELSEIF OLD.age_months >= 9 and NEW.age_months < 24 THEN
oldcolum1 := 'age9to24months';

ELSEIF OLD.age_months >= 24 and NEW.age_months < 60 THEN
oldcolum1 := 'age24to60months';

ELSEIF OLD.age_months >= 60 and NEW.age_months < 120 THEN
oldcolum1 := 'age60to120months';

ELSEIF OLD.age_months >= 120 and NEW.age_months < 180 THEN
oldcolum1 := 'age120to180months';

ELSEIF OLD.age_months >= 180 THEN
oldcolum1 := 'greaterthan180months';

ELSEIF OLD.age_months is NULL THEN
oldcolum1 := 'unknown';

END IF;

IF NEW.cross_notified <> 1 OR NEW.approval_status = 'Approved' THEN


      
      IF NEW.procode <> OLD.procode OR NEW.distcode <> OLD.distcode OR NEW.gender <> OLD.gender OR NEW.year <> OLD.year OR NEW.week <> OLD.week  OR dosesreceived <> olddosesreceived THEN
            BEGIN
         RAISE EXCEPTION 'First!';
            END;
         select exists(select * from caseepidcount_master WHERE dosenumber=dosesreceived AND gender::integer=newgender AND case_type=casetype AND selected_week=NEW.week AND year=NEW.year  AND distcode=NEW.distcode AND procode=NEW.procode) into notequalrowexist;
      IF notequalrowexist= TRUE THEN
         EXECUTE 'UPDATE caseepidcount_master set '||newcolum1||' = '||newcolum1||'+1 WHERE  gender::integer = '||newgender||' AND case_type = '''||casetype||'''  AND dosenumber = '||dosesreceived||' AND selected_week = '''||NEW.week||''' AND year = '''||NEW.year::text||'''  AND distcode = '''||NEW.distcode||''' AND procode = '''||NEW .procode||''' ';
         EXECUTE 'UPDATE caseepidcount_master set '||oldcolum1||' = '||oldcolum1||'-1 WHERE  gender::integer = '||oldgender||' AND case_type = '''||casetype||''' AND dosenumber = '||olddosesreceived||' AND selected_week = '''||OLD.week||''' AND year = '''||OLD.year::text||'''  AND distcode = '''||OLD.distcode||''' AND procode = '''||OLD.procode||''' ';
      ELSEIF notequalrowexist= FALSE THEN
	 EXECUTE 'INSERT INTO caseepidcount_master (procode,distcode,case_type,dosenumber,'||newcolum1||',gender,year,selected_week) values ('''||NEW.procode||''','''||NEW.distcode||''','''||casetype||''','||dosesreceived||',1,'||newgender||','''||NEW.year||''','''||NEW.week||''')';

      END IF;
ELSEIF  NEW.procode = OLD.procode AND NEW.distcode = OLD.distcode AND NEW.gender = OLD.gender AND NEW.year = OLD.year AND NEW.week = OLD.week  AND dosesreceived = olddosesreceived THEN 
         
      select exists(select * from caseepidcount_master WHERE dosenumber=dosesreceived AND gender::integer=newgender AND case_type=casetype AND selected_week=NEW.week AND year=NEW.year::text  AND distcode=NEW.distcode AND procode=NEW.procode) into equalrowexist;
      IF equalrowexist= TRUE THEN

         EXECUTE 'UPDATE caseepidcount_master set '||newcolum1||' = '||newcolum1||'+1 WHERE  gender::integer= '||newgender||' AND case_type = '''||casetype||''' AND dosenumber = '||dosesreceived||' AND selected_week = '''||NEW.week||''' AND year = '''||NEW.year::text||'''  AND distcode = '''||NEW.distcode||''' AND procode = '''||NEW .procode||'''  ';
         EXECUTE 'UPDATE caseepidcount_master set '||oldcolum1||' = '||oldcolum1||'-1 WHERE  gender::integer = '||oldgender||' AND case_type = '''||casetype||''' AND dosenumber = '||olddosesreceived||' AND selected_week = '''||OLD.week||''' AND year = '''||OLD.year::text||'''  AND distcode = '''||OLD.distcode||''' AND procode = '''||OLD .procode||'''  ';
      ELSEIF equalrowexist= FALSE THEN

         EXECUTE 'INSERT INTO caseepidcount_master (procode,distcode,case_type,dosenumber,'||newcolum1||',gender,year,selected_week) values ('''||NEW.procode||''','''||NEW.distcode||''','''||casetype||''','||dosesreceived||',1,'||newgender||','''||NEW.year||''','''||NEW.week||''')';  
      END IF;


END IF;
END IF;
 RETURN NEW;
END;$$;


ALTER FUNCTION public.casenntepidcount_master_update() OWNER TO postgres;

--
-- Name: closedvials_wastagerate(character varying, character varying, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION closedvials_wastagerate(ffmonth character varying, code character varying, consumption_id integer, vaccineid integer) RETURNS double precision
    LANGUAGE plpgsql
    AS $_$DECLARE
   rate double precision;
   whereText text;
   openingbalance integer;
   received integer;
   closingbalance integer;
   vialsused integer;
       BEGIN
            IF character_length(code) = '1' THEN
               whereText := 'procode';
            ELSIF character_length(code) = '3' THEN
               whereText := 'distcode';
            ELSIF character_length(code) = '6' THEN
               whereText := 'facode';
            ELSIF character_length(code) = '9' THEN
               whereText := 'uncode';
            ELSE
               return 0;
            END IF;
            
             EXECUTE ' SELECT round(coalesce(round(((sum(unused_doses))::numeric/NULLIF((sum(opening_doses)+sum(received_doses))-(sum(closing_doses))::numeric, 0))*100, 1),0)::numeric,0)  FROM epi_consumption_master  master left join epi_consumption_detail detail on master.pk_id=detail.main_id  where item_id='||$3||' and fmonth='''||ffmonth||''' and '||whereText||'='''||code||''' ' INTO rate; 

            IF rate < 0 THEN
               rate := 0;
            END IF;
            
            RETURN rate;
       END;$_$;


ALTER FUNCTION public.closedvials_wastagerate(ffmonth character varying, code character varying, consumption_id integer, vaccineid integer) OWNER TO postgres;

--
-- Name: FUNCTION closedvials_wastagerate(ffmonth character varying, code character varying, consumption_id integer, vaccineid integer); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION closedvials_wastagerate(ffmonth character varying, code character varying, consumption_id integer, vaccineid integer) IS 'according to new consumption table ';


--
-- Name: coldchain_record_check_delete(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION coldchain_record_check_delete() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
rowexist integer;

BEGIN

Select SUM(greatest(COALESCE(quantity),0)) from epi_stock_batch where ccm_id=OLD.asset_id into rowexist;

IF(rowexist) > 0 THEN
RAISE EXCEPTION 'Record Exits in Table';

END IF;
RETURN OLD;
END;$$;


ALTER FUNCTION public.coldchain_record_check_delete() OWNER TO postgres;

--
-- Name: consumption_master_delete_compliance(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION consumption_master_delete_compliance() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
rowexist boolean;
duecolumnname text;
subcolumnname text;
tsubcolumnname text;
duecount integer;
subcount integer;
timelycount integer;

BEGIN
duecount := get_monthly_fstatus_vacc(OLD.fmonth,OLD.distcode);
subcount := get_monthly_subm_consump(OLD.fmonth,OLD.distcode);
timelycount := get_monthly_tsubm_consump(OLD.fmonth,OLD.distcode);
subcolumnname := 'subm'||substring(OLD.fmonth from 6 for 2)::numeric;
tsubcolumnname := 'tsubm'||substring(OLD.fmonth from 6 for 2)::numeric;
duecolumnname := 'duem'||substring(OLD.fmonth from 6 for 2)::numeric;

select exists(select * from consumptioncompliance where year=substring(OLD.fmonth from 1 for 4) and distcode=OLD.distcode and procode=OLD.procode) into rowexist;
IF rowexist = TRUE THEN
      EXECUTE 'UPDATE consumptioncompliance set '||subcolumnname||' = '''||subcount||''', '||duecolumnname||' = '''||duecount||''',  '||tsubcolumnname||' ='''||timelycount ||''',flag=1  where year = '''||substring(OLD.fmonth from 1 for 4)||''' and distcode = '''||OLD.distcode||''' and procode = '''||OLD.procode||''' ';
END IF;
 RETURN OLD;
END;$$;


ALTER FUNCTION public.consumption_master_delete_compliance() OWNER TO postgres;

--
-- Name: FUNCTION consumption_master_delete_compliance(); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION consumption_master_delete_compliance() IS 'This function will execute when deletion of row occurs';


--
-- Name: consumption_master_insert_compliance(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION consumption_master_insert_compliance() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
rowexist boolean;
duecolumnname text;
subcolumnname text;
tsubcolumnname text;
duecount integer;
subcount integer;
timelycount integer;

BEGIN
duecount := get_monthly_fstatus_vacc(NEW.fmonth,NEW.distcode);
subcount := get_monthly_subm_consump(NEW.fmonth,NEW.distcode);
timelycount := get_monthly_tsubm_consump(NEW.fmonth,NEW.distcode);
subcolumnname := 'subm'||substring(NEW.fmonth from 6 for 2)::numeric;
tsubcolumnname := 'tsubm'||substring(NEW.fmonth from 6 for 2)::numeric;
duecolumnname := 'duem'||substring(NEW.fmonth from 6 for 2)::numeric;

select exists(select * from consumptioncompliance where year=substring(NEW.fmonth from 1 for 4) and distcode=NEW.distcode and procode=NEW.procode) into rowexist;
IF rowexist = FALSE THEN
	EXECUTE 'INSERT INTO consumptioncompliance(year,'||duecolumnname||', '||subcolumnname||', '||tsubcolumnname||',procode,distcode,flag) values ('''||substring(NEW.fmonth from 1 for 4)||''','''||duecount||''','''||subcount||''','''||timelycount ||''','''||NEW.procode||''','''||NEW.distcode||''',1)';
ELSEIF rowexist = TRUE THEN
        EXECUTE 'UPDATE consumptioncompliance set '||subcolumnname||' = '''||subcount||''', '||duecolumnname||' = '''||duecount||''',  '||tsubcolumnname||' ='''||timelycount ||''',flag=1  where year = '''||substring(NEW.fmonth from 1 for 4)||''' and distcode = '''||NEW.distcode||''' and procode = '''||NEW.procode||''' ';
END IF;
 RETURN NEW;
END;
$$;


ALTER FUNCTION public.consumption_master_insert_compliance() OWNER TO postgres;

--
-- Name: FUNCTION consumption_master_insert_compliance(); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION consumption_master_insert_compliance() IS 'this function will executre on insert of new record and act as trigger to update consumption compliance.';


--
-- Name: consumption_master_update_compliance(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION consumption_master_update_compliance() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
rowexist boolean;
tsubcolumnname text;
subcolumnname text;
duecolumnname text;
duecount integer;
subcount integer;
timelycount integer;

BEGIN

tsubcolumnname := 'tsubm'||substring(NEW.fmonth from 6 for 2)::numeric;
duecolumnname := 'duem'||substring(NEW.fmonth from 6 for 2)::numeric;
subcolumnname := 'subm'||substring(NEW.fmonth from 6 for 2)::numeric;
duecount := get_monthly_fstatus_vacc(NEW.fmonth,NEW.distcode);
subcount := get_monthly_subm_consump(NEW.fmonth,NEW.distcode);
timelycount := get_monthly_tsubm_consump(NEW.fmonth,NEW.distcode);

select exists(select * from consumptioncompliance where year=substring(NEW.fmonth from 1 for 4) and distcode=NEW.distcode and procode=NEW.procode) into rowexist;
IF rowexist = TRUE THEN
    EXECUTE 'UPDATE consumptioncompliance  set '||subcolumnname||' = '''||subcount||''', '||duecolumnname||' = '''||duecount||''',  '||tsubcolumnname||' ='''||timelycount ||''',flag=1  where year = '''||substring(NEW.fmonth from 1 for 4)||''' and distcode = '''||NEW.distcode||''' and procode = '''||NEW.procode||''' ';
  END IF;
  IF NEW.fmonth!= OLD.fmonth THEN
    tsubcolumnname := 'tsubm'||substring(OLD.fmonth from 6 for 2)::numeric;
    duecolumnname := 'duem'||substring(OLD.fmonth from 6 for 2)::numeric;
    subcolumnname := 'subm'||substring(OLD.fmonth from 6 for 2)::numeric;
    duecount := get_monthly_fstatus_vacc(OLD.fmonth,OLD.distcode);
    subcount := get_monthly_subm_consump(OLD.fmonth,OLD.distcode);
    timelycount := get_monthly_tsubm_consump(OLD.fmonth,OLD.distcode);
     select exists(select * from consumptioncompliance  where year=substring(OLD.fmonth from 1 for 4) and distcode=OLD.distcode and procode=OLD.procode) into rowexist;
             IF rowexist = TRUE THEN
    EXECUTE 'UPDATE consumptioncompliance  set '||subcolumnname||' = '''||subcount||''', '||duecolumnname||' = '''||duecount||''',  '||tsubcolumnname||' ='''||timelycount ||''',flag=1  where year = '''||substring(OLD.fmonth from 1 for 4)||''' and distcode = '''||OLD.distcode||''' and procode = '''||OLD.procode||''' ';
              END IF;
  END IF;
    RETURN NEW;
END;$$;


ALTER FUNCTION public.consumption_master_update_compliance() OWNER TO postgres;

--
-- Name: FUNCTION consumption_master_update_compliance(); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION consumption_master_update_compliance() IS 'This trigger will update due and submitted counts in consumptioncompliance table depending upon updation in epi_consumption_master';


--
-- Name: consumptioncompliance_delete(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION consumptioncompliance_delete() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
rowexist boolean;
duecolumnname text;
subcolumnname text;
tsubcolumnname text;
duecount integer;
timelyincrement integer;

BEGIN
duecount := get_monthly_fstatus_vacc(OLD.fmonth,OLD.distcode);
subcolumnname := 'subm'||substring(OLD.fmonth from 6 for 2)::numeric;
tsubcolumnname := 'tsubm'||substring(OLD.fmonth from 6 for 2)::numeric;
duecolumnname := 'duem'||substring(OLD.fmonth from 6 for 2)::numeric;

IF extract(day from OLD.date_submitted) <= 10 AND extract(Month from OLD.date_submitted - interval '1 month')::integer=substring(OLD.fmonth from 6 for 2)::integer THEN
        timelyincrement := 1;
ELSE
        timelyincrement := 0;
END IF;

select exists(select * from consumptioncompliance where year=substring(OLD.fmonth from 1 for 4) and distcode=OLD.distcode and procode=OLD.procode) into rowexist;
IF rowexist = TRUE THEN
        EXECUTE 'UPDATE consumptioncompliance set '||subcolumnname||' = '||subcolumnname||'-1,'||tsubcolumnname||' = '||tsubcolumnname||'-'''||timelyincrement||''','||duecolumnname||' = '''||duecount||'''  where year = '''||substring(OLD.fmonth from 1 for 4)||''' and distcode = '''||OLD.distcode||''' and procode = '''||OLD.procode||''' ';
END IF;
 RETURN OLD;
END;$$;


ALTER FUNCTION public.consumptioncompliance_delete() OWNER TO postgres;

--
-- Name: consumptioncompliance_insert(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION consumptioncompliance_insert() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
rowexist boolean;
duecolumnname text;
subcolumnname text;
tsubcolumnname text;
duecount integer;
timelyincrement integer;

BEGIN
duecount := get_monthly_fstatus_vacc(NEW.fmonth,NEW.distcode);
subcolumnname := 'subm'||substring(NEW.fmonth from 6 for 2)::numeric;
tsubcolumnname := 'tsubm'||substring(NEW.fmonth from 6 for 2)::numeric;
duecolumnname := 'duem'||substring(NEW.fmonth from 6 for 2)::numeric;

IF extract(day from NEW.date_submitted) <= 10 AND extract(Month from NEW.date_submitted - interval '1 month')::integer=substring(NEW.fmonth from 6 for 2)::integer THEN
        timelyincrement := 1;
ELSE
        timelyincrement := 0;
END IF;

select exists(select * from consumptioncompliance where year=substring(NEW.fmonth from 1 for 4) and distcode=NEW.distcode and procode=NEW.procode) into rowexist;
IF rowexist = FALSE THEN
	EXECUTE 'INSERT INTO consumptioncompliance (year,'||duecolumnname||','||subcolumnname||', '||tsubcolumnname||',procode,distcode) values ('''||substring(NEW.fmonth from 1 for 4)||''','''||duecount||''',1,'''||timelyincrement||''','''||NEW.procode||''','''||NEW.distcode||''')';
ELSEIF rowexist = TRUE THEN
        EXECUTE 'UPDATE consumptioncompliance set '||subcolumnname||' = '||subcolumnname||'+1,'||duecolumnname||' = '''||duecount||''',  '||tsubcolumnname||' = '||tsubcolumnname||'+'''||timelyincrement||'''  where year = '''||substring(NEW.fmonth from 1 for 4)||''' and distcode = '''||NEW.distcode||''' and procode = '''||NEW.procode||''' ';
END IF;
 RETURN NEW;
END;$$;


ALTER FUNCTION public.consumptioncompliance_insert() OWNER TO postgres;

--
-- Name: consumptioncompliance_update(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION consumptioncompliance_update() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
timelyincrement integer;
tsubcolumnname text;
duecolumnname text;
duecount integer;

BEGIN
timelyincrement := 0;
tsubcolumnname := 'tsubm'||substring(NEW.fmonth from 6 for 2)::numeric;
duecount := get_monthly_fstatus_vacc(NEW.fmonth,NEW.distcode);
duecolumnname := 'duem'||substring(NEW.fmonth from 6 for 2)::numeric;

    IF OLD.date_submitted = NEW.date_submitted THEN
        timelyincrement := 0;
        EXECUTE 'UPDATE consumptioncompliance set '||duecolumnname||' = '||duecount||' where year = '''||substring(NEW.fmonth from 1 for 4)||''' and distcode = '''||NEW.distcode||''' and procode = '''||NEW.procode||''' ';
    ELSEIF OLD.date_submitted <> NEW.date_submitted THEN
        IF extract(day from NEW.date_submitted) >= 10 AND extract(Month from NEW.date_submitted - interval '1 month')::integer=substring(NEW.fmonth from 6 for 2)::integer THEN
            timelyincrement := 1;
            EXECUTE 'UPDATE consumptioncompliance set '||tsubcolumnname||' = '||tsubcolumnname||'-'''||timelyincrement||''', '||duecolumnname||' = '''||duecount||'''  where year = '''||substring(NEW.fmonth from 1 for 4)||''' and distcode = '''||NEW.distcode||''' and procode = '''||NEW.procode||''' ';
        ELSEIF extract(day from NEW.date_submitted) <= 10 AND extract(Month from NEW.date_submitted - interval '1 month')::integer=substring(NEW.fmonth from 6 for 2)::integer THEN
            timelyincrement := 1;
            EXECUTE 'UPDATE consumptioncompliance set '||tsubcolumnname||' = '||tsubcolumnname||'+'''||timelyincrement||''', '||duecolumnname||' = '''||duecount||'''  where year = '''||substring(NEW.fmonth from 1 for 4)||''' and distcode = '''||NEW.distcode||''' and procode = '''||NEW.procode||''' ';
        END IF;
    END IF;
    RETURN NEW;
END;$$;


ALTER FUNCTION public.consumptioncompliance_update() OWNER TO postgres;

--
-- Name: countryname(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION countryname(ccode text) RETURNS text
    LANGUAGE plpgsql
    AS $$ DECLARE
        cname text;
    BEGIN
	SELECT country_name into cname from country where country_code=ccode;
        RETURN cname;
    END;$$;


ALTER FUNCTION public.countryname(ccode text) OWNER TO postgres;

--
-- Name: coveragerepcolumns(integer, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION coveragerepcolumns(itemid integer, antigen text) RETURNS text
    LANGUAGE plpgsql
    AS $$
DECLARE
    BEGIN
	IF itemid=2 THEN 
            RETURN 'bcg';
        ELSEIF itemid=3 and antigen = '1' THEN 
            RETURN 'pen_o';
        ELSEIF itemid=3 and antigen = '2' THEN 
            RETURN 'pen_tw';
        ELSEIF itemid=3 and antigen = '3' THEN 
            RETURN 'pen_th';
        ELSEIF itemid=4 and antigen = '1' THEN 
            RETURN 'pc_o';
        ELSEIF itemid=4 and antigen = '2' THEN 
            RETURN 'pc_tw';
        ELSEIF itemid=4 and antigen = '3' THEN 
            RETURN 'pc_th';
        ELSEIF itemid=5 and antigen = '1' THEN 
            RETURN 'mea_o';
        ELSEIF itemid=5 and antigen = '2' THEN 
            RETURN 'mea_tw';
        ELSEIF itemid=6 and antigen = '1' THEN 
            RETURN 'tt_o';
        ELSEIF itemid=6 and antigen = '2' THEN 
            RETURN 'tt_tw';
        ELSEIF itemid=6 and antigen = '3' THEN 
            RETURN 'tt_th';
        ELSEIF itemid=6 and antigen = '4' THEN 
            RETURN 'tt_fo';
        ELSEIF itemid=6 and antigen = '5' THEN 
            RETURN 'tt_fi';
        ELSEIF  itemid=15 and antigen = '0' THEN 
            RETURN 'opv_o';
        ELSEIF  itemid=15 and antigen = '1' THEN 
            RETURN 'opv_on';
        ELSEIF  itemid=15 and antigen = '2' THEN 
            RETURN 'opv_tw';
        ELSEIF  itemid=15 and antigen = '3' THEN 
            RETURN 'opv_th';
        ELSEIF itemid=17 THEN 
            RETURN 'ip_o';
        ELSEIF  itemid=19 and antigen = '1' THEN 
            RETURN 'rota_on';
        ELSEIF  itemid=19 and antigen = '2' THEN 
            RETURN 'rota_tw';
        ELSEIF  itemid=20 THEN 
            RETURN 'hep';
        ELSEIF  itemid=9999 THEN 
            RETURN 'fully_immunized';
        END IF;
END;
$$;


ALTER FUNCTION public.coveragerepcolumns(itemid integer, antigen text) OWNER TO postgres;

--
-- Name: disease_out_break_submitted_rate(character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION disease_out_break_submitted_rate(fweekk character varying, code character varying, vaccinename character varying) RETURNS double precision
    LANGUAGE plpgsql
    AS $$DECLARE
       rate double precision;
       total_expected_reports integer;
       total_submitted_reports integer;
       whereText text;
       vaccinTable text;
          BEGIN
            IF character_length(code) = '1' THEN
               whereText := 'procode';
            ELSIF character_length(code) = '3' THEN
               whereText := 'distcode';
            ELSIF character_length(code) = '6' THEN
               whereText := 'facode';
            ELSIF character_length(code) = '9' THEN
               whereText := 'uncode';
            ELSE
               return 0;
            END IF;
            IF vaccinename = 'Measles' THEN
                EXECUTE  'SELECT COUNT(*) FROM measle_case_investigation JOIN facilities ON measle_case_investigation.facode=facilities.facode WHERE facilities.'||whereText||'='''||code||''' AND measle_case_investigation.fweek='''||fweekk||''' ' INTO total_submitted_reports;
            ELSIF vaccinename = 'afp' THEN
               EXECUTE  'SELECT COUNT(*) FROM afp_case_investigation JOIN facilities ON afp_case_investigation.facode=facilities.facode WHERE facilities.'||whereText||'='''||code||''' AND afp_case_investigation.fweek='''||fweekk||''' ' INTO total_submitted_reports;
             ELSIF vaccinename = 'nnt' THEN
               EXECUTE  'SELECT COUNT(*) FROM nnt_investigation_form JOIN facilities ON nnt_investigation_form.facode=facilities.facode WHERE facilities.'||whereText||'='''||code||''' AND nnt_investigation_form.fweek='''||fweekk||''' ' INTO total_submitted_reports;
            ELSE
              return 0;
            END IF;
            EXECUTE 'SELECT COUNT(*) FROM facilities WHERE '||whereText||'='''||code||''' AND hf_type=''e'' ' INTO total_expected_reports;
            rate := ((total_submitted_reports::double precision/NULLIF(total_expected_reports,0)::double precision)*100)::double precision;
           RETURN rate;
      END;$$;


ALTER FUNCTION public.disease_out_break_submitted_rate(fweekk character varying, code character varying, vaccinename character varying) OWNER TO postgres;

--
-- Name: districtname(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION districtname(dcode text) RETURNS text
    LANGUAGE plpgsql
    AS $$
  DECLARE
        dname text;
    BEGIN
	SELECT district into dname from districts where distcode=dcode;
        RETURN dname;
    END;
  $$;


ALTER FUNCTION public.districtname(dcode text) OWNER TO postgres;

--
-- Name: epicenters_stockout(character varying, character varying, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION epicenters_stockout(ffmonth character varying, code character varying, vaccineid integer, dosespervial integer) RETURNS double precision
    LANGUAGE plpgsql
    AS $$DECLARE
   perc double precision;
   total_epicenters integer;
   stockout_epicenters integer;
   whereText text;
       BEGIN
            IF character_length(code) = '1' THEN
               whereText := 'procode';
            ELSIF character_length(code) = '3' THEN
               whereText := 'distcode';
            ELSIF character_length(code) = '6' THEN
               whereText := 'facode';
            ELSIF character_length(code) = '9' THEN
               whereText := 'uncode';
            ELSE
               return 0;
            END IF;

            EXECUTE 'SELECT COUNT(*) FROM facilities WHERE hf_type=''e'' AND '||whereText||'='''||code||''' ' INTO total_epicenters;
            EXECUTE 'SELECT COUNT(*) FROM form_b_cr WHERE cr_r'||vaccineID||'_f6<1 AND fmonth = '''||ffmonth||''' AND '||whereText||'='''||code||''' ' INTO stockout_epicenters;

            perc := (stockout_epicenters*100)::double precision/NULLIF((total_epicenters),0)::double precision;
            RETURN perc;
       END;$$;


ALTER FUNCTION public.epicenters_stockout(ffmonth character varying, code character varying, vaccineid integer, dosespervial integer) OWNER TO postgres;

--
-- Name: equipmenttypename(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION equipmenttypename(equipmentid integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
       equipmentname text;
       BEGIN
            SELECT equipment_type_name into equipmentname from epi_cc_equipment_types where pk_id=equipmentid;
            RETURN equipmentname;
       END;$$;


ALTER FUNCTION public.equipmenttypename(equipmentid integer) OWNER TO postgres;

--
-- Name: facilities_cumulative_population_insert(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION facilities_cumulative_population_insert() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
    rowexist boolean;
    


BEGIN
      
       --Manage UnionCouncil population
       select exists(select * from unioncouncil_population WHERE year=NEW.year and distcode=NEW.distcode) into rowexist;
	IF rowexist = TRUE THEN
               EXECUTE 'DELETE FROM unioncouncil_population WHERE year='''||NEW.year||''' and distcode='''||NEW.distcode||''' ';  
	END IF; 
       --Inster uc cumulative record  
       EXECUTE 'INSERT INTO unioncouncil_population(distcode, uncode, tcode, population, year)  select distcode,uncode,tcode,sum(population::integer),year from facilities_population where uncode like '''||NEW.distcode||'%'' and year = '''||NEW.year||''' group by distcode,tcode,uncode,year';


       --Manage Tehsil population
       select exists(select * from tehsil_population WHERE year=NEW.year and distcode=NEW.distcode) into rowexist;
	IF rowexist = TRUE THEN
               EXECUTE 'DELETE FROM tehsil_population WHERE year='''||NEW.year||''' and distcode='''||NEW.distcode||''' ';  
	END IF; 
       --Inster uc cumulative record  
       EXECUTE 'INSERT INTO tehsil_population(distcode, tcode, population, year)  select distcode,tcode,sum(population::integer),year from unioncouncil_population where tcode like '''||NEW.distcode||'%'' and year = '''||NEW.year||''' group by distcode,tcode,year';


       --Manage District population
       select exists(select * from districts_population WHERE year=NEW.year and distcode=NEW.distcode) into rowexist;
	IF rowexist = TRUE THEN
               EXECUTE 'DELETE FROM districts_population WHERE year='''||NEW.year||''' and distcode='''||NEW.distcode||''' ';  
	END IF;  
       --Inster uc cumulative record  
       EXECUTE 'INSERT INTO districts_population(distcode, population, year)  select distcode,sum(population::integer),year from tehsil_population where distcode like '''||NEW.distcode||'%'' and year = '''||NEW.year||''' group by distcode,year';

RETURN NEW;
END;
$$;


ALTER FUNCTION public.facilities_cumulative_population_insert() OWNER TO postgres;

--
-- Name: FUNCTION facilities_cumulative_population_insert(); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION facilities_cumulative_population_insert() IS 'INSERT data in facilities_population table, this trigger will updated on these two table (unioncouncil_population,tehsil_population,districts_population)';


--
-- Name: facilities_population_updated(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION facilities_population_updated() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE

sum_un_population character varying;
sum_tehsil_population character varying;
sum_districts_population character varying;

BEGIN

  EXECUTE 'SELECT sum(population::integer) FROM facilities_population where uncode = '''||NEW.uncode||''' and year = '''||NEW.year||''' group by uncode ' INTO sum_un_population;

  EXECUTE 'UPDATE unioncouncil_population set population = '||sum_un_population||' where uncode = '''||NEW.uncode||''' and year = '''||NEW.year||''' ';

  EXECUTE 'SELECT sum(population::integer) FROM facilities_population where tcode = '''||NEW.tcode||''' and year = '''||NEW.year||''' group by tcode ' INTO sum_tehsil_population;

  EXECUTE 'UPDATE tehsil_population set population = '||sum_tehsil_population||' where tcode = '''||NEW.tcode||''' and year = '''||NEW.year||''' ';

  EXECUTE 'SELECT sum(population::integer) FROM facilities_population where tcode = '''||NEW.tcode||''' and year = '''||NEW.year||''' group by tcode ' INTO sum_districts_population;

  EXECUTE 'UPDATE districts_population set population = '||sum_districts_population ||' where distcode = '''||NEW.distcode||''' and year = '''||NEW.year||''' ';

    RETURN NEW;
END;

$$;


ALTER FUNCTION public.facilities_population_updated() OWNER TO postgres;

--
-- Name: FUNCTION facilities_population_updated(); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION facilities_population_updated() IS 'Updated data in facilities_population table, this trigger will updated on these two table (unioncouncil_population,tehsil_population,districts_population)';


--
-- Name: facilities_record_check_delete(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION facilities_record_check_delete() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
rowexist1 boolean;
rowexist2 boolean;
rowexist3 boolean;
rowexist4 boolean;
rowexist5 boolean;
rowexist6 boolean;

BEGIN
         
        SELECT  EXISTS(SELECT DISTINCT facode  FROM  facilities_status      WHERE facode=OLD.facode) into rowexist1 ;
        SELECT  EXISTS(SELECT DISTINCT facode  FROM  facilities_population  WHERE facode=OLD.facode) into rowexist2;
        SELECT  EXISTS(SELECT DISTINCT facode  FROM  fac_mvrf_db            WHERE facode=OLD.facode) into rowexist3 ;
        SELECT  EXISTS(SELECT DISTINCT facode  FROM  epi_consumption_master WHERE facode=OLD.facode) into rowexist4 ;
        SELECT  EXISTS(SELECT DISTINCT facode  FROM  case_investigation_db  WHERE facode=OLD.facode)  into rowexist5 ;
        SELECT  EXISTS(SELECT DISTINCT facode  FROM  zero_report            WHERE facode=OLD.facode)  into rowexist6;
   IF rowexist1 = TRUE OR rowexist2= TRUE OR rowexist3= TRUE  OR rowexist4= TRUE OR rowexist5= TRUE OR rowexist6= TRUE  THEN

         RAISE EXCEPTION 'Record Exits in referencing Tables .!';
   
   END IF;
 RETURN OLD;
END;$$;


ALTER FUNCTION public.facilities_record_check_delete() OWNER TO postgres;

--
-- Name: facilityname(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION facilityname(fcode text) RETURNS text
    LANGUAGE plpgsql
    AS $$  DECLARE
        fname text;
    BEGIN
	SELECT fac_name into fname from facilities where facode=fcode;
        RETURN fname;
    END;
  $$;


ALTER FUNCTION public.facilityname(fcode text) OWNER TO postgres;

--
-- Name: facilitytype(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION facilitytype(fcode text) RETURNS text
    LANGUAGE plpgsql
    AS $$  DECLARE
        ftype text;
    BEGIN
	SELECT fatype into ftype from facilities where facode=fcode and hf_type='e';
        RETURN ftype;
    END;
  $$;


ALTER FUNCTION public.facilitytype(fcode text) OWNER TO postgres;

--
-- Name: flcf_vacc_mr_trigger(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION flcf_vacc_mr_trigger() RETURNS trigger
    LANGUAGE plpgsql
    AS $$begin
    new.cri_r1_f3 = 0;
    new.cri_r1_f4 = 0;
    new.cri_r1_f5 = 0;
    new.cri_r1_f6 = 0;
    new.cri_r1_f11 = 0;
    new.cri_r1_f12 = 0;
    new.cri_r2_f3 = 0;
    new.cri_r2_f4 = 0;
    new.cri_r2_f5 = 0;
    new.cri_r2_f6 = 0;
    new.cri_r2_f11 = 0;
    new.cri_r2_f12 = 0;
    new.cri_r3_f3 = 0;
    new.cri_r3_f4 = 0;
    new.cri_r3_f5 = 0;
    new.cri_r3_f6 = 0;
    new.cri_r3_f11 = 0;
    new.cri_r3_f12 = 0;
    new.cri_r10_f5 = 0;
    new.cri_r10_f6 = 0;
    new.cri_r11_f5 = 0;
    new.cri_r11_f6 = 0;
    new.cri_r12_f5 = 0;
    new.cri_r12_f6 = 0;
    new.cri_r15_f1 = 0;
    new.cri_r15_f2 = 0;
    new.cri_r15_f9 = 0;
    new.cri_r15_f10 = 0;
    return new;
end $$;


ALTER FUNCTION public.flcf_vacc_mr_trigger() OWNER TO postgres;

--
-- Name: gendername(character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION gendername(patient_gender character varying) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
        
    BEGIN
	IF patient_gender='1' THEN 
        RETURN 'Male';
   ELSE
      RETURN 'Female';
   END IF;
    END;$$;


ALTER FUNCTION public.gendername(patient_gender character varying) OWNER TO postgres;

--
-- Name: gendernames(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION gendernames(gender integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
     BEGIN
	IF gender=1 THEN 
        RETURN 'Male';
   ELSE
      RETURN 'Female';
   END IF;
    END;$$;


ALTER FUNCTION public.gendernames(gender integer) OWNER TO postgres;

--
-- Name: get_activity_name(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_activity_name(activity_type_id integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
        activity_name text;
    BEGIN
	SELECT activity into activity_name from epi_stakeholder_activities where pk_id=activity_type_id;
        RETURN activity_name;
    END;$$;


ALTER FUNCTION public.get_activity_name(activity_type_id integer) OWNER TO postgres;

--
-- Name: FUNCTION get_activity_name(activity_type_id integer); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION get_activity_name(activity_type_id integer) IS 'it function used for return activity from epi_stakeholder_activities with the help of activity_type_id.';


--
-- Name: get_all_facilities_stock_type(integer, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_all_facilities_stock_type(vaccineid integer, code character varying, columnname character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
   closing_balance integer;
       BEGIN
 IF vaccineID > 0 THEN    
            EXECUTE 'SELECT sum(cr_r'||vaccineID||'_f6) FROM form_b_cr join (select facode,max(fmonth) as fmonth from form_b_cr where '||columnname||' like   '''||code||'%'' group by facode) as moontbl on moontbl.facode = form_b_cr.facode and form_b_cr.fmonth = moontbl.fmonth' INTO closing_balance;
 END IF ;          
 RETURN closing_balance;
       END;$$;


ALTER FUNCTION public.get_all_facilities_stock_type(vaccineid integer, code character varying, columnname character varying) OWNER TO postgres;

--
-- Name: get_asset_status(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_asset_status(assetid integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
    currstatus integer;
BEGIN
    select status into currstatus from epi_cc_asset_status_history where ccm_id = assetid order by pk_id desc limit 1;
    RETURN currstatus;
END$$;


ALTER FUNCTION public.get_asset_status(assetid integer) OWNER TO postgres;

--
-- Name: get_capacity_litters(integer, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_capacity_litters(parent_asset_type_id integer, ccm_idd integer, ccm_model_idd integer) RETURNS double precision
    LANGUAGE plpgsql
    AS $$DECLARE
     output double precision;
   BEGIN
       IF parent_asset_type_id = 1 THEN
           SELECT coalesce(net_capacity_4,net_capacity_20,0) INTO output FROM epi_cc_models WHERE pk_id = ccm_model_idd;
--capacity is in litre
       ELSEIF parent_asset_type_id = 21 THEN
           SELECT (coalesce(net_capacity,0)*1000) INTO output FROM epi_ccm_cold_rooms WHERE ccm_id = ccm_idd;
--multiplied by 1000 to get capacity in litre
       END IF;
    RETURN output;
   END$$;


ALTER FUNCTION public.get_capacity_litters(parent_asset_type_id integer, ccm_idd integer, ccm_model_idd integer) OWNER TO postgres;

--
-- Name: get_commulative_fstatus_ds(integer, integer, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_commulative_fstatus_ds(year integer, tweak integer, dcode text) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
    t_fac text;
    fac text;
    i int;
BEGIN
    i :=0;
    fac :=0;
    t_fac :=0;
  IF dcode = '0' THEN
    FOR i IN 1..tweak LOOP
        SELECT SUM(case when getfstatus_ds(year || '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text, facode::text)='F' THEN 1 ELSE 0 END) INTO fac FROM facilities WHERE hf_type='e' AND is_ds_fac='1';
        t_fac := t_fac::numeric + fac::numeric;
    END LOOP;
  ELSEIF LENGTH(dcode) = 3 THEN
    FOR i IN 1..tweak LOOP
        SELECT SUM(case when getfstatus_ds(year || '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text, facode::text)='F' THEN 1 ELSE 0 END) INTO fac FROM facilities WHERE hf_type='e' AND is_ds_fac='1' and distcode=dcode;
        t_fac := t_fac::numeric + fac::numeric;
    END LOOP;
  ELSEIF LENGTH(dcode) = 6 THEN
    FOR i IN 1..tweak LOOP
        SELECT SUM(case when getfstatus_ds(year || '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text, facode::text)='F' THEN 1 ELSE 0 END) INTO fac FROM facilities WHERE hf_type='e' AND is_ds_fac='1' and facode=dcode;
        t_fac := t_fac::numeric + fac::numeric;
    END LOOP;
  ELSEIF LENGTH(dcode) = 9 THEN
    FOR i IN 1..tweak LOOP
        SELECT SUM(case when getfstatus_ds(year || '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text, facode::text)='F' THEN 1 ELSE 0 END) INTO fac FROM facilities WHERE hf_type='e' AND is_ds_fac='1' and uncode=dcode;
        t_fac := t_fac::numeric + fac::numeric;
    END LOOP;
  END IF;
    RETURN t_fac;
END$$;


ALTER FUNCTION public.get_commulative_fstatus_ds(year integer, tweak integer, dcode text) OWNER TO postgres;

--
-- Name: get_commulative_fstatus_ds1(integer, integer, text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_commulative_fstatus_ds1(year integer, tweak integer, dcode text, startweek integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
    t_fac text;
    fac text;
    i int;
BEGIN
    i :=startweek;
    fac :=0;
    t_fac :=0;
  IF dcode = '0' THEN
    FOR i IN startweek..tweak LOOP
        SELECT SUM(case when getfstatus_ds(year || '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text, facode::text)='F' THEN 1 ELSE 0 END) INTO fac FROM facilities WHERE hf_type='e' AND is_ds_fac='1';
        t_fac := t_fac::numeric + fac::numeric;
    END LOOP;
  ELSEIF LENGTH(dcode) = 3 THEN
    FOR i IN startweek..tweak LOOP
        SELECT SUM(case when getfstatus_ds(year || '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text, facode::text)='F' THEN 1 ELSE 0 END) INTO fac FROM facilities WHERE hf_type='e' AND is_ds_fac='1' and distcode=dcode;
        t_fac := t_fac::numeric + fac::numeric;
    END LOOP;
  ELSEIF LENGTH(dcode) = 6 THEN
    FOR i IN startweek..tweak LOOP
        SELECT SUM(case when getfstatus_ds(year || '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text, facode::text)='F' THEN 1 ELSE 0 END) INTO fac FROM facilities WHERE hf_type='e' AND is_ds_fac='1' and facode=dcode;
        t_fac := t_fac::numeric + fac::numeric;
    END LOOP;
  ELSEIF LENGTH(dcode) = 9 THEN
    FOR i IN startweek..tweak LOOP
        SELECT SUM(case when getfstatus_ds(year || '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text, facode::text)='F' THEN 1 ELSE 0 END) INTO fac FROM facilities WHERE hf_type='e' AND is_ds_fac='1' and uncode=dcode;
        t_fac := t_fac::numeric + fac::numeric;
    END LOOP;
  END IF;
    RETURN t_fac;
END$$;


ALTER FUNCTION public.get_commulative_fstatus_ds1(year integer, tweak integer, dcode text, startweek integer) OWNER TO postgres;

--
-- Name: get_commulative_fstatus_vacc(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_commulative_fstatus_vacc(fmon text, dcode text) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
    t_fac text;
    fac text;
    fmonth text;
    year int;
    month int;
    i int;
BEGIN
    i :=0;
    fac :=0;
    t_fac :=0;
    year := substring(fmon from 1 for 4);
    month := substring(fmon from 6 for 2);
  IF dcode = '0' THEN
    FOR i IN 1..month LOOP
        fmonth = year || '-' || TRIM(BOTH ' ' FROM to_char(i, '09'));
        SELECT SUM(case when getfstatus_vacc(fmonth::text, facode::text)='F' THEN 1 ELSE 0 END) INTO fac FROM facilities WHERE hf_type='e' AND is_vacc_fac='1';
        t_fac := t_fac::numeric + fac::numeric;
    END LOOP;
  ELSEIF LENGTH(dcode)=3 THEN
    FOR i IN 1..month LOOP
        fmonth = year || '-' || TRIM(BOTH ' ' FROM to_char(i, '09'));
        SELECT SUM(case when getfstatus_vacc(fmonth::text, facode::text)='F' THEN 1 ELSE 0 END) INTO fac FROM facilities WHERE hf_type='e' AND is_vacc_fac='1' and distcode=dcode;
        t_fac := t_fac::numeric + fac::numeric;
    END LOOP;
  ELSEIF LENGTH(dcode)=6 THEN
    FOR i IN 1..month LOOP
        fmonth = year || '-' || TRIM(BOTH ' ' FROM to_char(i, '09'));
        SELECT SUM(case when getfstatus_vacc(fmonth::text, facode::text)='F' THEN 1 ELSE 0 END) INTO fac FROM facilities WHERE hf_type='e' AND is_vacc_fac='1' and facode=dcode;
        t_fac := t_fac::numeric + fac::numeric;
    END LOOP;
  END IF;
    RETURN t_fac;
END$$;


ALTER FUNCTION public.get_commulative_fstatus_vacc(fmon text, dcode text) OWNER TO postgres;

--
-- Name: get_commulative_fstatus_vacc1(text, text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_commulative_fstatus_vacc1(fmon text, dcode text, startmonth integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
    t_fac text;
    fac text;
    fmonth text;
    year int;
    month int;
    i int;
BEGIN
    i :=startmonth;
    fac :=0;
    t_fac :=0;
    year := substring(fmon from 1 for 4);
    month := substring(fmon from 6 for 2);
  IF dcode = '0' THEN
    FOR i IN startmonth..month LOOP
        fmonth = year || '-' || TRIM(BOTH ' ' FROM to_char(i, '09'));
        SELECT SUM(case when getfstatus_vacc(fmonth::text, facode::text)='F' THEN 1 ELSE 0 END) INTO fac FROM facilities WHERE hf_type='e' AND is_vacc_fac='1';
        t_fac := t_fac::numeric + fac::numeric;
    END LOOP;
  ELSEIF LENGTH(dcode)=3 THEN
    FOR i IN startmonth..month LOOP
        fmonth = year || '-' || TRIM(BOTH ' ' FROM to_char(i, '09'));
        SELECT SUM(case when getfstatus_vacc(fmonth::text, facode::text)='F' THEN 1 ELSE 0 END) INTO fac FROM facilities WHERE hf_type='e' AND is_vacc_fac='1' and distcode=dcode;
        t_fac := t_fac::numeric + fac::numeric;
    END LOOP;
  ELSEIF LENGTH(dcode)=6 THEN
    FOR i IN startmonth..month LOOP
        fmonth = year || '-' || TRIM(BOTH ' ' FROM to_char(i, '09'));
        SELECT SUM(case when getfstatus_vacc(fmonth::text, facode::text)='F' THEN 1 ELSE 0 END) INTO fac FROM facilities WHERE hf_type='e' AND is_vacc_fac='1' and facode=dcode;
        t_fac := t_fac::numeric + fac::numeric;
    END LOOP;
  END IF;
    RETURN t_fac;
END$$;


ALTER FUNCTION public.get_commulative_fstatus_vacc1(fmon text, dcode text, startmonth integer) OWNER TO postgres;

--
-- Name: get_commulative_sub_ds(integer, integer, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_commulative_sub_ds(year integer, tweak integer, dcode text) RETURNS text
    LANGUAGE plpgsql
    AS $_$DECLARE
    t_sub text;
    sub text;
    fweekk text;
    year text;
    i int;
BEGIN
    i :=0;
    t_sub :=0;
    sub :=0;
    year:=$1;
    
  IF dcode = '0' THEN
  
    FOR i IN 1..tweak LOOP
    
    SELECT count(*) INTO sub FROM zero_report JOIN facilities ON zero_report.facode=facilities.facode WHERE getfstatus_ds($1|| '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text,zero_report.facode::text)='F' AND report_submitted='1'   AND zero_report.fweek like $1|| '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text and week::numeric > 0;     

        t_sub := t_sub ::numeric + sub ::numeric;
    END LOOP;
  ELSEIF LENGTH(dcode) = 3 THEN
    FOR i IN 1..tweak LOOP
        SELECT count(*) INTO sub FROM zero_report JOIN facilities ON zero_report.facode=facilities.facode WHERE getfstatus_ds($1|| '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text,zero_report.facode::text)='F'  AND zero_report.distcode=dcode AND report_submitted='1'   AND zero_report.fweek like $1|| '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text and week::numeric > 0;     

        t_sub := t_sub ::numeric + sub ::numeric;
    END LOOP;
  ELSEIF LENGTH(dcode) = 6 THEN
    FOR i IN 1..tweak LOOP
        SELECT count(*) INTO sub FROM zero_report JOIN facilities ON zero_report.facode=facilities.facode WHERE getfstatus_ds($1|| '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text,zero_report.facode::text)='F' AND zero_report.facode=dcode AND report_submitted='1'   AND zero_report.fweek like $1|| '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text and week::numeric > 0;     

        t_sub := t_sub ::numeric + sub ::numeric;
    END LOOP;
    ELSEIF LENGTH(dcode) = 9 THEN
    FOR i IN 1..tweak LOOP
        SELECT count(*) INTO sub FROM zero_report JOIN facilities ON zero_report.facode=facilities.facode WHERE getfstatus_ds($1|| '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text,zero_report.facode::text)='F' AND zero_report.uncode=dcode AND report_submitted='1'   AND zero_report.fweek like $1|| '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text and week::numeric > 0;     

        t_sub := t_sub ::numeric + sub ::numeric;
    END LOOP;
  END IF;
    RETURN t_sub ;
END$_$;


ALTER FUNCTION public.get_commulative_sub_ds(year integer, tweak integer, dcode text) OWNER TO postgres;

--
-- Name: get_commulative_tsub_ds(integer, integer, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_commulative_tsub_ds(year integer, tweak integer, dcode text) RETURNS text
    LANGUAGE plpgsql
    AS $_$DECLARE
    t_sub text;
    sub text;
    fweekk text;
    year text;
    i int;
BEGIN
    i :=0;
    t_sub :=0;
    sub :=0;
    year:=$1;
    
  IF dcode = '0' THEN
  
    FOR i IN 1..tweak LOOP
    
    SELECT count(*) INTO sub FROM zero_report JOIN facilities ON zero_report.facode=facilities.facode WHERE getfstatus_ds($1|| '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text,zero_report.facode::text)='F' AND report_submitted='1'  AND zero_report.submitted_date IS NOT NULL  AND zero_report.fweek like $1|| '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text and week::numeric > 0;     

        t_sub := t_sub ::numeric + sub ::numeric;
    END LOOP;
  ELSEIF LENGTH(dcode) = 3 THEN
    FOR i IN 1..tweak LOOP
        SELECT count(*) INTO sub FROM zero_report JOIN facilities ON zero_report.facode=facilities.facode WHERE getfstatus_ds($1|| '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text,zero_report.facode::text)='F'  AND zero_report.distcode=dcode AND report_submitted='1' AND zero_report.submitted_date IS NOT NULL  AND zero_report.fweek like $1|| '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text and week::numeric > 0;     

        t_sub := t_sub ::numeric + sub ::numeric;
    END LOOP;
  ELSEIF LENGTH(dcode) = 6 THEN
    FOR i IN 1..tweak LOOP
        SELECT count(*) INTO sub FROM zero_report JOIN facilities ON zero_report.facode=facilities.facode WHERE getfstatus_ds($1|| '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text,zero_report.facode::text)='F' AND zero_report.facode=dcode AND report_submitted='1'  AND zero_report.submitted_date IS NOT NULL  AND zero_report.fweek like $1|| '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text and week::numeric > 0;     

        t_sub := t_sub ::numeric + sub ::numeric;
    END LOOP;
    ELSEIF LENGTH(dcode) = 9 THEN
    FOR i IN 1..tweak LOOP
        SELECT count(*) INTO sub FROM zero_report JOIN facilities ON zero_report.facode=facilities.facode WHERE getfstatus_ds($1|| '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text,zero_report.facode::text)='F' AND zero_report.uncode=dcode AND report_submitted='1' AND zero_report.submitted_date IS NOT NULL  AND zero_report.fweek like $1|| '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text and week::numeric > 0;     

        t_sub := t_sub ::numeric + sub ::numeric;
    END LOOP;
  END IF;
    RETURN t_sub ;
END$_$;


ALTER FUNCTION public.get_commulative_tsub_ds(year integer, tweak integer, dcode text) OWNER TO postgres;

--
-- Name: get_cr_table_row_numb_id(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_cr_table_row_numb_id(item_id integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        cr_id integer;
        itemid integer=item_id;
    BEGIN
	SELECT cr_table_row_numb into cr_id from epi_item_pack_sizes where pk_id=itemid;
        RETURN cr_id ;
    END;$$;


ALTER FUNCTION public.get_cr_table_row_numb_id(item_id integer) OWNER TO postgres;

--
-- Name: FUNCTION get_cr_table_row_numb_id(item_id integer); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION get_cr_table_row_numb_id(item_id integer) IS 'Its will get item "cr_table_row_numb" id from "epi_item_pack_sizes" table on base of item id in parameter.;';


--
-- Name: get_curr_stock_quantity(timestamp without time zone, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_curr_stock_quantity(enddatee timestamp without time zone, whtypee character varying, itemid integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
     output integer;
   BEGIN
        SELECT coalesce(sum(quantity),0) INTO output FROM epi_stock_batch batch JOIN epi_stock_master master ON master.pk_id = batch.batch_master_id JOIN epi_transaction_types tt ON tt.pk_id = master.transaction_type_id JOIN epi_item_pack_sizes sizes ON sizes.pk_id = batch.item_pack_size_id WHERE batch.item_pack_size_id = itemid and master.transaction_date <= enddatee and master.draft = '0' and tt.nature = '1' AND master.to_warehouse_type_id = whtypee::integer and batch.status != 'Finished';
    RETURN output;
   END;$$;


ALTER FUNCTION public.get_curr_stock_quantity(enddatee timestamp without time zone, whtypee character varying, itemid integer) OWNER TO postgres;

--
-- Name: FUNCTION get_curr_stock_quantity(enddatee timestamp without time zone, whtypee character varying, itemid integer); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION get_curr_stock_quantity(enddatee timestamp without time zone, whtypee character varying, itemid integer) IS 'This function will return current available stock quantity of an item in vials/pieces at given store Level like Provincial stores, district level stores etc.
It is similar to another function aswell except parameter count only';


--
-- Name: get_curr_stock_quantity(timestamp without time zone, character varying, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_curr_stock_quantity(enddatee timestamp without time zone, whtypee character varying, whcodee character varying, itemid integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
     output double precision;
   BEGIN
        SELECT coalesce(sum(quantity),0) INTO output FROM epi_stock_batch batch JOIN epi_stock_master master ON master.pk_id = batch.batch_master_id JOIN epi_transaction_types tt ON tt.pk_id = master.transaction_type_id WHERE batch.item_pack_size_id = itemid and master.transaction_date <= enddatee and master.draft = '0' and tt.nature = '1' AND master.to_warehouse_type_id = whtypee::integer and master.to_warehouse_code= whcodee  and batch.status != 'Finished';
    RETURN output;
   END;$$;


ALTER FUNCTION public.get_curr_stock_quantity(enddatee timestamp without time zone, whtypee character varying, whcodee character varying, itemid integer) OWNER TO postgres;

--
-- Name: FUNCTION get_curr_stock_quantity(enddatee timestamp without time zone, whtypee character varying, whcodee character varying, itemid integer); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION get_curr_stock_quantity(enddatee timestamp without time zone, whtypee character varying, whcodee character varying, itemid integer) IS 'This function will return current available stock quantity of an item in vials/pieces at given store.';


--
-- Name: get_epi_item_dose_per_vials(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_epi_item_dose_per_vials(prodid integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        doses integer;
    BEGIN
	SELECT number_of_doses into doses from epi_item_pack_sizes where pk_id=prodid;
        RETURN doses;
    END;$$;


ALTER FUNCTION public.get_epi_item_dose_per_vials(prodid integer) OWNER TO postgres;

--
-- Name: get_epi_trans_no(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_epi_trans_no(master_id integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
        number text;
    BEGIN
	SELECT transaction_number into number from epi_stock_master where pk_id=master_id;
        RETURN number;
    END;$$;


ALTER FUNCTION public.get_epi_trans_no(master_id integer) OWNER TO postgres;

--
-- Name: get_epi_transaction_type_nature(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_epi_transaction_type_nature(adjustment_type integer) RETURNS character
    LANGUAGE plpgsql
    AS $$DECLARE
        naturetype character;
    BEGIN
	SELECT nature into naturetype from epi_transaction_types where pk_id=adjustment_type;
        RETURN naturetype ;
    END;$$;


ALTER FUNCTION public.get_epi_transaction_type_nature(adjustment_type integer) OWNER TO postgres;

--
-- Name: FUNCTION get_epi_transaction_type_nature(adjustment_type integer); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION get_epi_transaction_type_nature(adjustment_type integer) IS 'To get nature column from epi_transaction_types table on base of adjustment_type.';


--
-- Name: get_hr_status(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_hr_status(hr_code character varying, post_sub_id character varying) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
        hr_status text;
    BEGIN

         SELECT post_status into hr_status FROM (SELECT DISTINCT ON (code) code,code AS same_code,* FROM hr_db_history  ORDER BY code DESC, id DESC) AS a WHERE post_hr_sub_type_id=post_sub_id AND same_code=hr_code;

	RETURN hr_status;
    END;$$;


ALTER FUNCTION public.get_hr_status(hr_code character varying, post_sub_id character varying) OWNER TO postgres;

--
-- Name: get_hr_sub_type_description(character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_hr_sub_type_description(hr_sub_type_idd character varying) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
        hr_sub_type_dis text;
    BEGIN
	SELECT description into hr_sub_type_dis from hr_sub_types where type_id = hr_sub_type_idd;
        RETURN hr_sub_type_dis;
    END;$$;


ALTER FUNCTION public.get_hr_sub_type_description(hr_sub_type_idd character varying) OWNER TO postgres;

--
-- Name: get_indicator_periodic_multiplier_dist_target(character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_indicator_periodic_multiplier_dist_target(indicators character varying, yearr character varying, ocode character varying) RETURNS double precision
    LANGUAGE plpgsql
    AS $$DECLARE
        constant double precision;
    BEGIN 
        IF character_length(ocode) >= '3' THEN   
            SELECT formula_multiplier into constant from indicator_periodic_multiplier where code=substring(ocode,1,3) and level='3' and indicator=indicators and  yearr >= start_year and ( yearr <=end_year or end_year='');
        ELSE
	        SELECT formula_multiplier into constant from indicator_periodic_multiplier where code=substring(ocode,1,1) and level='2' and indicator=indicators and  yearr >= start_year and (yearr <=end_year or end_year='');
        END IF;

        IF constant IS NULL THEN
            constant:= 0;
        ELSE
	        constant:= constant;
	    END IF;
       
    RETURN constant;       
    END;$$;


ALTER FUNCTION public.get_indicator_periodic_multiplier_dist_target(indicators character varying, yearr character varying, ocode character varying) OWNER TO postgres;

--
-- Name: get_item_categories(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_item_categories(category integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
        cname text;
    BEGIN
	SELECT item_category_name into cname from epi_item_categories where pk_id=category;
        RETURN cname;
    END;$$;


ALTER FUNCTION public.get_item_categories(category integer) OWNER TO postgres;

--
-- Name: get_monthly_fstatus_vacc(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_monthly_fstatus_vacc(fmon text, dcode text) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
    t_fac text;
    fac text;
    fmonth text;
    year int;
    month int;
    i int;
BEGIN
    fac :=0;
    t_fac :=0;
    year := substring(fmon from 1 for 4);
    month := substring(fmon from 6 for 2);
    i := 0;
  IF dcode = '0' THEN
    FOR i IN month..month LOOP
        fmonth = year || '-' || TRIM(BOTH ' ' FROM to_char(i, '09'));
        SELECT SUM(case when getfstatus_vacc(fmonth::text, facode::text)='F' THEN 1 ELSE 0 END) INTO fac FROM facilities WHERE hf_type='e' AND is_vacc_fac='1';
        t_fac := t_fac::numeric + fac::numeric;
    END LOOP;
  ELSEIF LENGTH(dcode)=3 THEN
    FOR i IN month..month LOOP
        fmonth = year || '-' || TRIM(BOTH ' ' FROM to_char(i, '09'));
        SELECT SUM(case when getfstatus_vacc(fmonth::text, facode::text)='F' THEN 1 ELSE 0 END) INTO fac FROM facilities WHERE hf_type='e' AND is_vacc_fac='1' and distcode=dcode;
        t_fac := t_fac::numeric + fac::numeric;
    END LOOP;
  ELSEIF LENGTH(dcode)=6 THEN
    FOR i IN month..month LOOP
        fmonth = year || '-' || TRIM(BOTH ' ' FROM to_char(i, '09'));
        SELECT SUM(case when getfstatus_vacc(fmonth::text, facode::text)='F' THEN 1 ELSE 0 END) INTO fac FROM facilities WHERE hf_type='e' AND is_vacc_fac='1' and facode=dcode;
        t_fac := t_fac::numeric + fac::numeric;
    END LOOP;
  END IF;
    RETURN t_fac;
END$$;


ALTER FUNCTION public.get_monthly_fstatus_vacc(fmon text, dcode text) OWNER TO postgres;

--
-- Name: get_monthly_subm_consump(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_monthly_subm_consump(fmon text, dcode text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
       subcount integer;
   BEGIN

select count(facode)  from epi_consumption_master where fmonth=fmon and distcode=dcode and getfstatus_vacc(fmon,facode)='F' into subcount ;

  RETURN subcount ;
END$$;


ALTER FUNCTION public.get_monthly_subm_consump(fmon text, dcode text) OWNER TO postgres;

--
-- Name: get_monthly_subm_vacc(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_monthly_subm_vacc(fmon text, dcode text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
       subcount integer;
   BEGIN

select count(facode)  from fac_mvrf_db where fmonth=fmon and distcode=dcode and getfstatus_vacc(fmon,facode)='F' into subcount ;

  RETURN subcount ;
END$$;


ALTER FUNCTION public.get_monthly_subm_vacc(fmon text, dcode text) OWNER TO postgres;

--
-- Name: get_monthly_tsubm_consump(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_monthly_tsubm_consump(fmon text, dcode text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
       subcount integer;
   BEGIN

select count(facode) as tsub from epi_consumption_master where fmonth =fmon and distcode =dcode  and getfstatus_vacc(fmon,facode) = 'F' and extract(day from created_date) <= 10 and extract(Month from created_date- interval '1 month')::integer=substring(fmonth from 6 for 2)::integer into subcount; 
  RETURN subcount ;
END$$;


ALTER FUNCTION public.get_monthly_tsubm_consump(fmon text, dcode text) OWNER TO postgres;

--
-- Name: get_monthly_tsubm_vacc(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_monthly_tsubm_vacc(fmon text, dcode text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
       subcount integer;
   BEGIN


select count(facode) as tsub from fac_mvrf_db   where fmonth =fmon and distcode =dcode  and getfstatus_vacc(fmon,facode) = 'F' and extract(day from submitted_date) <= 10 and extract(Month from submitted_date - interval '1 month')::integer=substring(fmonth from 6 for 2)::integer into subcount; 
  RETURN subcount ;
END$$;


ALTER FUNCTION public.get_monthly_tsubm_vacc(fmon text, dcode text) OWNER TO postgres;

--
-- Name: get_pro_level_all_fac_closing_bal(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_pro_level_all_fac_closing_bal(vaccineid integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
   closing_balance integer;
       BEGIN
 IF vaccineID> 0 THEN
            EXECUTE 'select sum(closing_doses) as balance from epi_consumption_detail join epi_consumption_master on epi_consumption_master.pk_id = epi_consumption_detail.main_id join  (select facode,max(fmonth) as fmonth from epi_consumption_master group by facode) as moontbl on moontbl.facode = epi_consumption_master.facode and epi_consumption_master.fmonth = moontbl.fmonth where main_id>0 and (item_id='||vaccineID||')' INTO closing_balance;
 END IF ;          
 RETURN closing_balance;
       END;$$;


ALTER FUNCTION public.get_pro_level_all_fac_closing_bal(vaccineid integer) OWNER TO postgres;

--
-- Name: FUNCTION get_pro_level_all_fac_closing_bal(vaccineid integer); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION get_pro_level_all_fac_closing_bal(vaccineid integer) IS 'vaccineID is actually vaccine table row number from html form,
This function will return single vaccine (id in parameter) provincial sum from closing balance of facilities last submitted report';


--
-- Name: get_pro_level_all_fac_closing_bal(integer, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_pro_level_all_fac_closing_bal(vaccineid integer, code character varying, columnname character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
   closing_balance integer;
       BEGIN
 IF vaccineID > 0 THEN    
            EXECUTE 'select sum(closing_doses) as balance from epi_consumption_detail join epi_consumption_master on epi_consumption_master.pk_id = epi_consumption_detail.main_id join  (select facode,max(fmonth) as fmonth from epi_consumption_master  where   '||columnname||' like   '''||code||'%'' group by facode) as moontbl on moontbl.facode = epi_consumption_master.facode and epi_consumption_master.fmonth = moontbl.fmonth where main_id>0 and (item_id='||vaccineID||')' INTO closing_balance;
 END IF ;          
 RETURN closing_balance;
       END;

$$;


ALTER FUNCTION public.get_pro_level_all_fac_closing_bal(vaccineid integer, code character varying, columnname character varying) OWNER TO postgres;

--
-- Name: get_pro_level_all_fac_stock_out(integer, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_pro_level_all_fac_stock_out(vaccineid integer, fmonthh character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
   stock_out integer;
       BEGIN

            EXECUTE 'SELECT count(*) FROM form_b_cr where cr_r'||vaccineID||'_f6<1 and fmonth = '''||fmonthh||''' ' INTO stock_out;
            RETURN stock_out;
       END;$$;


ALTER FUNCTION public.get_pro_level_all_fac_stock_out(vaccineid integer, fmonthh character varying) OWNER TO postgres;

--
-- Name: FUNCTION get_pro_level_all_fac_stock_out(vaccineid integer, fmonthh character varying); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION get_pro_level_all_fac_stock_out(vaccineid integer, fmonthh character varying) IS 'vaccineID is actually vaccine table row number from html form,
This function will return single vaccine (id in parameter) provincial stock out facilities count from closing balance of facilities submitted report of month provided in parameter';


--
-- Name: get_pro_level_all_fac_stock_out(text[], character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_pro_level_all_fac_stock_out(vaccineid text[], fmonthh character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $_$DECLARE
   stock_out integer;
   whr text;
       BEGIN
            whr = array_to_string($1,' and ');
            EXECUTE 'SELECT count(*) FROM form_b_cr where '||whr||' and fmonth = '''||fmonthh||''' ' INTO stock_out;
            RETURN stock_out;
       END;$_$;


ALTER FUNCTION public.get_pro_level_all_fac_stock_out(vaccineid text[], fmonthh character varying) OWNER TO postgres;

--
-- Name: FUNCTION get_pro_level_all_fac_stock_out(vaccineid text[], fmonthh character varying); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION get_pro_level_all_fac_stock_out(vaccineid text[], fmonthh character varying) IS 'vaccineID is actually vaccine table row number from html form,
This function will return single vaccine (id in parameter) provincial stock out facilities count from closing balance of facilities submitted report of month provided in parameter';


--
-- Name: get_pro_level_all_fac_stock_out(text[], character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_pro_level_all_fac_stock_out(vaccineid text[], fmonthh character varying, distcode character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $_$DECLARE
   stock_out integer;
   whr text;
       BEGIN
            whr = array_to_string($1,' and ');
            EXECUTE 'SELECT count(*) FROM form_b_cr where '||whr||' and fmonth = '''||fmonthh||''' and distcode= '''||distcode||''' ' INTO stock_out;
            RETURN stock_out;
       END;$_$;


ALTER FUNCTION public.get_pro_level_all_fac_stock_out(vaccineid text[], fmonthh character varying, distcode character varying) OWNER TO postgres;

--
-- Name: get_pro_level_all_fac_stock_out(text[], character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_pro_level_all_fac_stock_out(vaccineid text[], fmonthh character varying, columnname character varying, code character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $_$DECLARE
   stock_out integer;
   whr text;
       BEGIN
            whr = array_to_string($1,' and ');
            EXECUTE 'SELECT count(*) FROM form_b_cr where '||whr||' and fmonth = '''||fmonthh||''' and '||columnname||' like   '''||code||'%''' INTO stock_out;
            RETURN stock_out;
       END;$_$;


ALTER FUNCTION public.get_pro_level_all_fac_stock_out(vaccineid text[], fmonthh character varying, columnname character varying, code character varying) OWNER TO postgres;

--
-- Name: get_pro_level_all_fac_stock_out_new(text[], character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_pro_level_all_fac_stock_out_new(vaccine_id text[], fmonthh character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $_$DECLARE
   stock_out integer;
 whr text;
 whrr text;
       BEGIN
            whr= array_to_string($1,' OR ');
            whrr := '(' ||whr|| ')';
            EXECUTE 'select count(*) from(select main_id as balance from epi_consumption_detail join epi_consumption_master on epi_consumption_master.pk_id = epi_consumption_detail.main_id 
					where main_id>0 and  
                               '||whrr||'
					and fmonth = '''||fmonthh||'''
                                        and is_compiled= 1
				     group by fmonth,main_id having sum(closing_doses) < 1
				) as innerq' INTO stock_out;

            RETURN stock_out;
          
       END;$_$;


ALTER FUNCTION public.get_pro_level_all_fac_stock_out_new(vaccine_id text[], fmonthh character varying) OWNER TO postgres;

--
-- Name: FUNCTION get_pro_level_all_fac_stock_out_new(vaccine_id text[], fmonthh character varying); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION get_pro_level_all_fac_stock_out_new(vaccine_id text[], fmonthh character varying) IS ' For HF stock out rate for new table. "epi_consumption_master,epi_consumption_detail".';


--
-- Name: get_pro_level_all_fac_stock_out_new(text[], character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_pro_level_all_fac_stock_out_new(vaccine_id text[], fmonthh character varying, columnname character varying, code character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $_$DECLARE
   stock_out integer;
 whr text;
 whrr text;
       BEGIN
            whr= array_to_string($1,' OR ');
            whrr := '(' ||whr|| ')';

            EXECUTE 'select count(*) from(select main_id as balance from epi_consumption_detail join epi_consumption_master on epi_consumption_master.pk_id = epi_consumption_detail.main_id 
					where main_id>0 and  
                               '||whrr||'
					and fmonth = '''||fmonthh||'''
					and '||columnname||' like   '''||code||'%''
                                        and is_compiled= 1
					group by fmonth,main_id having sum(closing_doses) < 1
				) as innerq
			' INTO stock_out;

            RETURN stock_out;
          
       END;$_$;


ALTER FUNCTION public.get_pro_level_all_fac_stock_out_new(vaccine_id text[], fmonthh character varying, columnname character varying, code character varying) OWNER TO postgres;

--
-- Name: FUNCTION get_pro_level_all_fac_stock_out_new(vaccine_id text[], fmonthh character varying, columnname character varying, code character varying); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION get_pro_level_all_fac_stock_out_new(vaccine_id text[], fmonthh character varying, columnname character varying, code character varying) IS 'For HF stock out rate for new table. "epi_consumption_master,epi_consumption_detail".';


--
-- Name: get_pro_level_all_fac_stock_out_rate(integer, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_pro_level_all_fac_stock_out_rate(vaccineid integer, fmonthh character varying) RETURNS double precision
    LANGUAGE plpgsql
    AS $$DECLARE
   perc double precision;
   total_submitted_rep integer;
   stock_out integer;
       BEGIN

            EXECUTE 'SELECT COUNT(*) FROM form_b_cr WHERE fmonth = '''||fmonthh||''' ' INTO total_submitted_rep;
            EXECUTE 'SELECT count(*) FROM form_b_cr where cr_r'||vaccineid||'_f6<1 and fmonth = '''||fmonthh||''' ' INTO stock_out;
            
            perc := (stock_out*100)::double precision/NULLIF((total_submitted_rep),0)::double precision;
            RETURN perc;
       END;$$;


ALTER FUNCTION public.get_pro_level_all_fac_stock_out_rate(vaccineid integer, fmonthh character varying) OWNER TO postgres;

--
-- Name: FUNCTION get_pro_level_all_fac_stock_out_rate(vaccineid integer, fmonthh character varying); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION get_pro_level_all_fac_stock_out_rate(vaccineid integer, fmonthh character varying) IS 'vaccineID is actually vaccine table row number from html form,
This function will return single vaccine (id in parameter) provincial stock out facilities count from closing balance of facilities submitted report of month provided in parameter';


--
-- Name: get_product_name(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_product_name(prodid integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
        itemname text;
    BEGIN
	SELECT item_name into itemname from epi_item_pack_sizes where pk_id=prodid;
        RETURN itemname;
    END;$$;


ALTER FUNCTION public.get_product_name(prodid integer) OWNER TO postgres;

--
-- Name: get_stackholder_activity_name(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_stackholder_activity_name(stckhldractvtyid integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
     namee text;
   BEGIN
    SELECT activity into namee from epi_stakeholder_activities where pk_id=stckhldractvtyid;
   RETURN namee;
   END$$;


ALTER FUNCTION public.get_stackholder_activity_name(stckhldractvtyid integer) OWNER TO postgres;

--
-- Name: get_stakeholder_sectors(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_stakeholder_sectors(sectors_type integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
        cname text;
    BEGIN
	SELECT stakeholder_sector_name into cname from epi_stakeholder_sectors where pk_id=sectors_type;
        RETURN cname;
    END;$$;


ALTER FUNCTION public.get_stakeholder_sectors(sectors_type integer) OWNER TO postgres;

--
-- Name: get_stakeholder_type(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_stakeholder_type(stakeholder_type integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
        cname text;
    BEGIN
	SELECT stakeholder_type_name into cname from epi_stakeholder_types where pk_id=stakeholder_type;
        RETURN cname;
    END;$$;


ALTER FUNCTION public.get_stakeholder_type(stakeholder_type integer) OWNER TO postgres;

--
-- Name: get_store_name(integer, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_store_name(storetype integer, storecode character varying) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
    namee text;
    distname text;
BEGIN
    IF storetype = 0 THEN
        IF length(storecode) = 1 THEN
           namee = 'Unallocated (Provincial)';
        ELSEIF length(storecode) = 3 THEN
           select districtname(storecode) into distname from districts where distcode = storecode;
           namee = 'Unallocated ('|| distname || ')';
        END IF;
    ELSEIF storetype = 1 THEN
        namee = 'Federal Vaccine Store';
    ELSEIF storetype = 2 THEN
        select province || ' EPI Store' into namee from provinces where procode = storecode;
    ELSEIF storetype = 4 THEN
        select 'District ' || district || ' Store' into namee from districts where distcode = storecode;
    ELSEIF storetype = 5 THEN
        select 'Tehsil ' || tehsil || ' Store' into namee from tehsil where tcode = storecode; 
    ELSEIF storetype = 6 THEN
        select 'Facility ' || fac_name || ' Store' into namee from facilities where facode = storecode;
    ELSEIF storetype = 7 THEN
        select stakeholder_name into namee from epi_stakeholders where pk_id::text = storecode;
    END IF;
    RETURN namee;
END$$;


ALTER FUNCTION public.get_store_name(storetype integer, storecode character varying) OWNER TO postgres;

--
-- Name: get_stored_quantity_litters(integer, timestamp without time zone, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_stored_quantity_litters(ccm_idd integer, enddatee timestamp without time zone, whtypee character varying, whcodee character varying) RETURNS double precision
    LANGUAGE plpgsql
    AS $$DECLARE
     output double precision;
   BEGIN
        SELECT coalesce(sum(quantity*(select volume_per_vial from epi_stakeholder_item_pack_sizes where stakeholder_id = batch.stakeholder_id and item_pack_size_id = batch.item_pack_size_id limit 1)*0.001),0) INTO output FROM epi_stock_batch batch JOIN epi_stock_master master ON master.pk_id = batch.batch_master_id JOIN epi_transaction_types tt ON tt.pk_id = master.transaction_type_id JOIN epi_item_pack_sizes sizes ON sizes.pk_id = batch.item_pack_size_id WHERE master.transaction_date <= enddatee and sizes.item_category_id = '1' and master.draft = '0' and tt.nature = '1' AND master.to_warehouse_type_id = whtypee::integer and master.to_warehouse_code= whcodee and batch.ccm_id = ccm_idd and batch.status != 'Finished';
    RETURN output;
   END;

--*1000$$;


ALTER FUNCTION public.get_stored_quantity_litters(ccm_idd integer, enddatee timestamp without time zone, whtypee character varying, whcodee character varying) OWNER TO postgres;

--
-- Name: FUNCTION get_stored_quantity_litters(ccm_idd integer, enddatee timestamp without time zone, whtypee character varying, whcodee character varying); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION get_stored_quantity_litters(ccm_idd integer, enddatee timestamp without time zone, whtypee character varying, whcodee character varying) IS 'it will give current stored quantity in item in litters
--formula is total stored quantity in vials * volume per vial in cubic centi meter * 0.001 (to change into lires)';


--
-- Name: get_weekly_fstatus_ds(integer, integer, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_weekly_fstatus_ds(year integer, tweak integer, dcode text) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
    t_fac text;
    fac text;
    i int;
BEGIN
    i :=0;
    fac :=0;
    t_fac :=0;
  IF dcode = '0' THEN
    FOR i IN tweak..tweak LOOP
        SELECT SUM(case when getfstatus_ds(year || '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text, facode::text)='F' THEN 1 ELSE 0 END) INTO fac FROM facilities WHERE hf_type='e' AND is_ds_fac='1';
        t_fac := t_fac::numeric + fac::numeric;
    END LOOP;
  ELSEIF LENGTH(dcode) = 3 THEN
    FOR i IN tweak..tweak LOOP
        SELECT SUM(case when getfstatus_ds(year || '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text, facode::text)='F' THEN 1 ELSE 0 END) INTO fac FROM facilities WHERE hf_type='e' AND is_ds_fac='1' and distcode=dcode;
        t_fac := t_fac::numeric + fac::numeric;
    END LOOP;
  ELSEIF LENGTH(dcode) = 6 THEN
    FOR i IN tweak..tweak LOOP
        SELECT SUM(case when getfstatus_ds(year || '-' || TRIM(BOTH ' ' FROM to_char(i, '09'))::text, facode::text)='F' THEN 1 ELSE 0 END) INTO fac FROM facilities WHERE hf_type='e' AND is_ds_fac='1' and facode=dcode;
        t_fac := t_fac::numeric + fac::numeric;
    END LOOP;
  END IF;
    RETURN t_fac;
END$$;


ALTER FUNCTION public.get_weekly_fstatus_ds(year integer, tweak integer, dcode text) OWNER TO postgres;

--
-- Name: getcba(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getcba(ocode text, otype text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        totpop integer;
    BEGIN
        SELECT round((getpopulation(ocode,otype)::integer*22) / 100) into totpop;
	
        RETURN totpop;
    END$$;


ALTER FUNCTION public.getcba(ocode text, otype text) OWNER TO postgres;

--
-- Name: getcbapop(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getcbapop(ocode text, otype text, yearr text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        totpop integer;
    BEGIN
        SELECT round((getpopulationpop(ocode,otype,yearr)::integer*get_indicator_periodic_multiplier_dist_target('cba',yearr,ocode)) / 100) into totpop;
    
        RETURN totpop;
    END$$;


ALTER FUNCTION public.getcbapop(ocode text, otype text, yearr text) OWNER TO postgres;

--
-- Name: getcbapop_old(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getcbapop_old(ocode text, otype text, yearr text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        totpop integer;
    BEGIN
        SELECT round((getpopulationpop(ocode,otype,yearr)::integer*22) / 100) into totpop;
	
        RETURN totpop;
    END$$;


ALTER FUNCTION public.getcbapop_old(ocode text, otype text, yearr text) OWNER TO postgres;

--
-- Name: getccmshortname(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getccmshortname(ccmid integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
       asname text;
   BEGIN
       SELECT short_name into asname from epi_cc_coldchain_main where asset_id=ccmid;
   RETURN asname;
END$$;


ALTER FUNCTION public.getccmshortname(ccmid integer) OWNER TO postgres;

--
-- Name: getcommulative_newborn(text, text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getcommulative_newborn(ocode text, otype text, no_of_months integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        commulativenewborn integer;
    BEGIN
        SELECT round(getmonthly_newborn(ocode,otype)::integer*no_of_months) into commulativenewborn;
	
        RETURN commulativenewborn;
    END;


--DECLARE
  --      commulativenewborn integer;
    --BEGIN
      --  SELECT round(getmonthly_newborn(ocode,otype)::integer*no_of_months,2) into commulativenewborn;
	
        --RETURN commulativenewborn;
    --END;$$;


ALTER FUNCTION public.getcommulative_newborn(ocode text, otype text, no_of_months integer) OWNER TO postgres;

--
-- Name: getcommulative_newbornpop(text, text, integer, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getcommulative_newbornpop(ocode text, otype text, no_of_months integer, yearr text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        commulativenewborn integer;
    BEGIN
        SELECT round(getmonthly_newbornpop(ocode,otype,yearr)::integer*no_of_months) into commulativenewborn;
	
        RETURN commulativenewborn;
    END;$$;


ALTER FUNCTION public.getcommulative_newbornpop(ocode text, otype text, no_of_months integer, yearr text) OWNER TO postgres;

--
-- Name: getepidcode(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getepidcode(dcode text) RETURNS text
    LANGUAGE plpgsql
    AS $$ DECLARE
        epidcodee text;
    BEGIN
	SELECT epid_code into epidcodee from districts where distcode=dcode;
        RETURN epidcodee;
    END;$$;


ALTER FUNCTION public.getepidcode(dcode text) OWNER TO postgres;

--
-- Name: getfacility_aefi_count(character varying, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getfacility_aefi_count(code character varying, wherefield text, fmonth text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        number_aefireporting_hf text;
    BEGIN
	if wherefield='district' then
	  SELECT count(distinct facode) into number_aefireporting_hf from aefi_rep where distcode=code and datefrom::text like fmonth;
	end if;      
	if wherefield='tehsil' then
	  SELECT (case when count(distinct facode) > 0 THEN 1 ELSE 0 END) into number_aefireporting_hf from aefi_rep where tcode=code and datefrom::text like fmonth;
	end if;
         if wherefield='unioncouncil' then
	  SELECT (case when count(distinct facode) > 0 THEN 1 ELSE 0 END) into number_aefireporting_hf from aefi_rep where uncode=code and datefrom::text like fmonth;
	end if;
	

        RETURN number_aefireporting_hf;
    END;$$;


ALTER FUNCTION public.getfacility_aefi_count(code character varying, wherefield text, fmonth text) OWNER TO postgres;

--
-- Name: getfacility_afp_count(character varying, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getfacility_afp_count(code character varying, wherefield text, fmonth text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        number_afpreporting_hf text;
    BEGIN
	if wherefield='district' then
	  SELECT count(distinct facode) into number_afpreporting_hf from afp_case_investigation where distcode=code and datefrom::text like fmonth;
	end if;      
	if wherefield='tehsil' then
	  SELECT (case when count(distinct facode) > 0 THEN 1 ELSE 0 END) into number_afpreporting_hf from afp_case_investigation where tcode=code and datefrom::text like fmonth;
	end if;
	 if wherefield='unioncouncil' then
	  SELECT (case when count(distinct facode) > 0 THEN 1 ELSE 0 END) into number_afpreporting_hf from afp_case_investigation where uncode=code and datefrom::text like fmonth;
	end if;

        RETURN number_afpreporting_hf;
    END;$$;


ALTER FUNCTION public.getfacility_afp_count(code character varying, wherefield text, fmonth text) OWNER TO postgres;

--
-- Name: getfacility_count(character varying, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getfacility_count(code character varying, wherefield text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        number_hf text;
    BEGIN
	if wherefield='district' then
	  SELECT count(facode) into number_hf from facilities where distcode=code and hf_type='e';
	end if;
       if wherefield='unioncouncil' then
	  SELECT count(facode) into number_hf from facilities where uncode=code and hf_type='e';
	end if;
	if wherefield='tehsil' then
	  SELECT count(facode) into number_hf from facilities where tcode=code and hf_type='e';
	end if;
        if wherefield='facility' then
	  SELECT count(facode) into number_hf from facilities where facode=code and hf_type='e';
	end if;
	

        RETURN number_hf;
    END;$$;


ALTER FUNCTION public.getfacility_count(code character varying, wherefield text) OWNER TO postgres;

--
-- Name: getfacility_msl_othercases_count(character varying, text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getfacility_msl_othercases_count(code character varying, wherefield text, casename text, fmonth text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        number_mslreporting_hf text;
    BEGIN
	if wherefield='district' then
	  SELECT count(distinct facode) into number_mslreporting_hf from case_investigation_db where distcode=code and case_type=casename and datefrom::text like fmonth;
	end if;       
	if wherefield='tehsil' then
	  SELECT (case when count(distinct facode) > 0 THEN 1 ELSE 0 END) into number_mslreporting_hf from case_investigation_db where tcode=code and case_type=casename and datefrom::text like fmonth;
	end if;
	if wherefield='unioncouncil' then
	  SELECT (case when count(distinct facode) > 0 THEN 1 ELSE 0 END) into number_mslreporting_hf from case_investigation_db where uncode=code and case_type=casename and datefrom::text like fmonth;
	end if;

        RETURN number_mslreporting_hf;
    END;$$;


ALTER FUNCTION public.getfacility_msl_othercases_count(code character varying, wherefield text, casename text, fmonth text) OWNER TO postgres;

--
-- Name: getfacility_nnt_count(character varying, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getfacility_nnt_count(code character varying, wherefield text, fmonth text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        number_nntreporting_hf text;
    BEGIN
	if wherefield='district' then
	  SELECT count(distinct facode) into number_nntreporting_hf from nnt_investigation_form where distcode=code and datefrom::text like fmonth;
	end if;       
	if wherefield='tehsil' then
	  SELECT (case when count(distinct facode) > 0 THEN 1 ELSE 0 END) into number_nntreporting_hf from nnt_investigation_form where tcode=code and datefrom::text like fmonth;
	end if;
	if wherefield='unioncouncil' then
	  SELECT (case when count(distinct facode) > 0 THEN 1 ELSE 0 END) into number_nntreporting_hf from nnt_investigation_form where uncode=code and datefrom::text like fmonth;
	end if;

        RETURN number_nntreporting_hf;
    END;$$;


ALTER FUNCTION public.getfacility_nnt_count(code character varying, wherefield text, fmonth text) OWNER TO postgres;

--
-- Name: getfacility_reports_count(character varying, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getfacility_reports_count(code character varying, wherefield text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        number_reporting_hf text;
    BEGIN
	if wherefield='district' then
	  SELECT count(facode) into number_reporting_hf from fac_mvrf_db where distcode=code;
	end if;
       if wherefield='unioncouncil' then
	  SELECT count(facode) into number_reporting_hf from fac_mvrf_db where uncode=code;
	end if;
	if wherefield='tehsil' then
	  SELECT count(facode) into number_reporting_hf from fac_mvrf_db where tcode=code;
	end if;
	

        RETURN number_reporting_hf;
    END;$$;


ALTER FUNCTION public.getfacility_reports_count(code character varying, wherefield text) OWNER TO postgres;

--
-- Name: getfstatus_ds(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getfstatus_ds(fweek1 text, fcode text) RETURNS text
    LANGUAGE plpgsql
    AS $$   DECLARE
      r facilities_status%rowtype;
      status text;
      fstatus text;
      mon text;
      pmon text;
      cmon text;
      i int;
   BEGIN
      fstatus := '';
      i:=0;
      mon := substring(fweek1,0,5)||substring(fweek1,6);
      FOR r IN SELECT fs.* FROM facilities_status fs join facilities on fs.facode=facilities.facode WHERE facilities.facode=fcode and facilities.hf_type='e' and facilities.is_ds_fac='1' AND w_y_from IS NOT NULL order by substring(w_y_from, 0,5)||substring(w_y_from,6), id 
      LOOP
        cmon := substring(r.w_y_from,0,5)||substring(r.w_y_from,6);
        IF mon < cmon then
           --do notthing;
        ELSIF mon = cmon then
          status := r.status;
          i := i + 1;
        ELSE     --means greater
          IF i > 0 then
            IF mon >= pmon then
              status :=r.status;
            END IF;
          ELSE 
            status :=r.status;
            END IF;
          pmon :=cmon;
          i := i + 1;
        END IF;
      END LOOP;
      IF i >= 1 THEN 
        fstatus := status;
      END IF;
      RETURN fstatus;
   END$$;


ALTER FUNCTION public.getfstatus_ds(fweek1 text, fcode text) OWNER TO postgres;

--
-- Name: getfstatus_ds_bck(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getfstatus_ds_bck(fweek1 text, fcode text) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
    r facilities_status%rowtype;
    status text;
    fstatus text;
    mon text;
    pmon text;
    cmon text;
    i int;
BEGIN
    i := 0;
    mon := substring(fweek1,0,5)||substring(fweek1,6);
    FOR r IN SELECT * FROM facilities_status WHERE facode=fcode AND w_y_from IS NOT NULL order by substring(w_y_from, 0,5)||substring(w_y_from,6), id 
    LOOP
        cmon := substring(r.w_y_from,0,5)||substring(r.w_y_from,6);
        if i > 0 then
            if mon >= pmon and mon < cmon then
                fstatus:=status;
            else 
                if mon >= cmon then
                    fstatus:=r.status;
                end if;
            end if;
        end if;
        pmon := cmon;
        if r.w_y_from is not null then
            status := r.status;
        else
            status := '';
        end if;
        i := i + 1;
    END LOOP;
    if i = 1 then
       fstatus := status;
    end if;
    if i = 0 then
       fstatus := 'F';
    end if;
    RETURN fstatus;
END$$;


ALTER FUNCTION public.getfstatus_ds_bck(fweek1 text, fcode text) OWNER TO postgres;

--
-- Name: getfstatus_vacc(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getfstatus_vacc(fmonth1 text, fcode text) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
  r facilities_status%rowtype;
 status text;
 fstatus text;
 mon text;
 pmon text;
 cmon text;
 i int;
 BEGIN
   fstatus := '';
   i:=0;
   mon := substring(fmonth1,0,5)||substring(fmonth1,6);
    FOR r IN SELECT fs.* FROM facilities_status fs join facilities on fs.facode=facilities.facode WHERE facilities.facode=fcode and facilities.hf_type='e' and facilities.is_vacc_fac='1' AND m_y_from IS NOT NULL order by substring(m_y_from, 0,5)||substring(m_y_from,6),fs.id LOOP
   cmon := substring(r.m_y_from,0,5)||substring(r.m_y_from,6);
   IF mon < cmon then
   --do notthing;
   ELSIF mon = cmon then
    status := r.status;
    i := i + 1;
   ELSE   -- means greater
    IF i > 0 then
     IF mon >= pmon then
      status :=r.status;
      END IF;
    ELSE 
     status :=r.status;
     END IF;
    pmon :=cmon;
    i := i + 1;
   END IF;
  END LOOP;
  IF i >= 1 THEN 
   fstatus := status;
   END IF;
  RETURN fstatus;
 END$$;


ALTER FUNCTION public.getfstatus_vacc(fmonth1 text, fcode text) OWNER TO postgres;

--
-- Name: getfstatus_vacc_bck(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getfstatus_vacc_bck(fmonth1 text, fcode text) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
    r facilities_status%rowtype;
 status text;
 fstatus text;
 mon text;
 pmon text;
 cmon text;
 i int;
BEGIN
 i:=0;
 mon := substring(fmonth1,0,5)||substring(fmonth1,6);
    FOR r IN SELECT * FROM facilities_status WHERE facode=fcode AND m_y_from IS NOT NULL order by substring(m_y_from, 0,5)||substring(m_y_from,6), id LOOP
  cmon := substring(r.m_y_from,0,5)||substring(r.m_y_from,6);
  if i > 0 then
   if mon >= pmon and mon < cmon then
    fstatus:=status;
   else 
      if mon >= cmon then
    fstatus:=r.status;
      end if;
   end if;
  end if;
  pmon := cmon;
  if r.m_y_from is not null then
    status := r.status;
  else
    status := '';
  end if;
  i := i + 1;
    END LOOP;
    if i = 1 then
       fstatus := status;
    end if;
    if i = 0 then
       fstatus := 'F';
    end if;

    RETURN fstatus;
END
  $$;


ALTER FUNCTION public.getfstatus_vacc_bck(fmonth1 text, fcode text) OWNER TO postgres;

--
-- Name: getfundingsoucrename(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getfundingsoucrename(warehouseid integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
        warehousename text;
    BEGIN
	SELECT name into warehousename from epi_funding_source where id=warehouseid;
        RETURN warehousename;
END;$$;


ALTER FUNCTION public.getfundingsoucrename(warehouseid integer) OWNER TO postgres;

--
-- Name: getlevel_name(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getlevel_name(level text) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $$DECLARE
        levelname text;
    BEGIN
	SELECT name into levelname from hr_levels where code=level;
        RETURN levelname;
    END;$$;


ALTER FUNCTION public.getlevel_name(level text) OWNER TO postgres;

--
-- Name: getmonthly_newborn(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getmonthly_newborn(ocode text, otype text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        monthlynewborn integer;
    BEGIN
        SELECT getnewborn(ocode,otype)/12 into monthlynewborn;
	
        RETURN round(monthlynewborn);
    END;$$;


ALTER FUNCTION public.getmonthly_newborn(ocode text, otype text) OWNER TO postgres;

--
-- Name: getmonthly_newbornpop(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getmonthly_newbornpop(ocode text, otype text, yearr text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        monthlynewborn integer;
    BEGIN
        SELECT getnewbornpop(ocode,otype,yearr)/12 into monthlynewborn;
	
        RETURN round(monthlynewborn);
    END;$$;


ALTER FUNCTION public.getmonthly_newbornpop(ocode text, otype text, yearr text) OWNER TO postgres;

--
-- Name: getmonthly_plwomen_target(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getmonthly_plwomen_target(code character varying, yearr character varying) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
   yearly_target text;
   pl_target text;
       BEGIN
            yearly_target = getyearly_plwomen_target(code,'');
            pl_target = yearly_target::numeric / 12 ;
            RETURN pl_target::numeric;
       END;$$;


ALTER FUNCTION public.getmonthly_plwomen_target(code character varying, yearr character varying) OWNER TO postgres;

--
-- Name: FUNCTION getmonthly_plwomen_target(code character varying, yearr character varying); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION getmonthly_plwomen_target(code character varying, yearr character varying) IS 'year functionality is not yet implemented. Later on target monthly population will be based on year. ';


--
-- Name: getmonthly_plwomen_target_specificyears(text, integer, integer, integer, integer, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getmonthly_plwomen_target_specificyears(code text, startyearr integer, sm integer, endyearr integer, em integer, otype text DEFAULT ''::text) RETURNS text
    LANGUAGE plpgsql
    AS $$
DECLARE
    target_pop text;
    start_months integer;
        BEGIN
            target_pop=0;
            FOR i IN startyearr..endyearr LOOP  
                IF i=startyearr THEN 
                    IF startyearr=endyearr THEN 
                        start_months = (em-sm)+1; 
                    ELSE
                        start_months = (12-sm)+1;
                    END IF;
                ELSEIF 
                    i=endyearr THEN start_months = (em-sm)+1;
                END IF;             
                IF i=startyearr THEN

                    IF character_length(code) = '6' AND otype = 'tehsil' THEN
                        target_pop:=target_pop::numeric+getmonthly_plwomen_targetpop(code::character varying,startyearr::character varying,'tehsil'::character varying)::numeric*start_months;
                    ELSE
                        target_pop:=target_pop::numeric+getmonthly_plwomen_targetpop(code::character varying,startyearr::character varying)::numeric*start_months;
                    END IF;

                ELSEIF i=endyearr THEN 
                    IF target_pop IS NULL THEN 
                        target_pop:=0;
                    ELSE
                
                        IF character_length(code) = '6' AND otype = 'tehsil' THEN
                           target_pop:=target_pop::numeric+getmonthly_plwomen_targetpop(code::character varying,endyearr::character varying,'tehsil'::character varying)::numeric*start_months;
                        ELSE
                           target_pop:=target_pop::numeric+getmonthly_plwomen_targetpop(code::character varying,endyearr::character varying)::numeric*start_months;
                        END IF;

                    END IF;
                ELSE

                    IF character_length(code) = '6' AND otype = 'tehsil' THEN
                       target_pop:=target_pop::numeric+getmonthly_plwomen_targetpop(code::character varying,i::character varying,'tehsil'::character varying)::numeric*12;
                    ELSE
                       target_pop:=target_pop::numeric+getmonthly_plwomen_targetpop(code::character varying,i::character varying)::numeric*12;
                    END IF;

                END IF;
            END LOOP;
            RETURN target_pop;
        END;
        $$;


ALTER FUNCTION public.getmonthly_plwomen_target_specificyears(code text, startyearr integer, sm integer, endyearr integer, em integer, otype text) OWNER TO postgres;

--
-- Name: getmonthly_plwomen_targetpop(character varying, character varying, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getmonthly_plwomen_targetpop(code character varying, yearr character varying, otype text DEFAULT ''::text) RETURNS numeric
    LANGUAGE plpgsql
    AS $$
DECLARE
   	yearly_target text;
   	pl_target numeric;
       	BEGIN
            
            IF character_length(code) = '6' AND otype = 'tehsil' THEN
               yearly_target = getyearly_plwomen_targetpop(code,yearr,'tehsil'::text);           
            ELSE
               yearly_target = getyearly_plwomen_targetpop(code,yearr);
            END IF;  

            pl_target = yearly_target::numeric / 12;
            RETURN pl_target::numeric;
        END;
        $$;


ALTER FUNCTION public.getmonthly_plwomen_targetpop(code character varying, yearr character varying, otype text) OWNER TO postgres;

--
-- Name: getmonthly_survivinginfants(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getmonthly_survivinginfants(ocode text, otype text) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
   yearly_target text;
   pl_target text;
       BEGIN
            yearly_target = (getnewborn(ocode,otype) * 94.2) / 100;
            pl_target =yearly_target::numeric / 12 ;
            RETURN pl_target;
       END;$$;


ALTER FUNCTION public.getmonthly_survivinginfants(ocode text, otype text) OWNER TO postgres;

--
-- Name: getmonthly_survivinginfantspop(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getmonthly_survivinginfantspop(ocode text, otype text, yearr text) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
    yearly_target text;
    pl_target text;
    BEGIN
        yearly_target = (getnewbornpop(ocode,otype,yearr) * get_indicator_periodic_multiplier_dist_target('survivinginfants',yearr,ocode)) / 100;
        pl_target =yearly_target::numeric / 12 ;
        RETURN pl_target;
    END;$$;


ALTER FUNCTION public.getmonthly_survivinginfantspop(ocode text, otype text, yearr text) OWNER TO postgres;

--
-- Name: getmonthly_survivinginfantspop_old(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getmonthly_survivinginfantspop_old(ocode text, otype text, yearr text) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
   yearly_target text;
   pl_target text;
       BEGIN
            yearly_target = (getnewbornpop(ocode,otype,yearr) * 94.2) / 100;
            pl_target =yearly_target::numeric / 12 ;
            RETURN pl_target;
       END;$$;


ALTER FUNCTION public.getmonthly_survivinginfantspop_old(ocode text, otype text, yearr text) OWNER TO postgres;

--
-- Name: getmonthlynewborn_targetpopulation(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getmonthlynewborn_targetpopulation(code character varying, yearr character varying) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
   yearly_target text;
   monthly_target text;
       BEGIN
            yearly_target = getyearlynewborn_targetpopulation(code,'');
            monthly_target =yearly_target::numeric / 12;
            RETURN monthly_target;
       END;$$;


ALTER FUNCTION public.getmonthlynewborn_targetpopulation(code character varying, yearr character varying) OWNER TO postgres;

--
-- Name: FUNCTION getmonthlynewborn_targetpopulation(code character varying, yearr character varying); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION getmonthlynewborn_targetpopulation(code character varying, yearr character varying) IS 'year functionality is not yet implemented. Later on target monthly population will be based on year. ';


--
-- Name: getmonthlynewborn_targetpopulationpop(character varying, character varying, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getmonthlynewborn_targetpopulationpop(code character varying, yearr character varying, otype text DEFAULT ''::text) RETURNS text
    LANGUAGE plpgsql
    AS $$
DECLARE
   	yearly_target text;
    monthly_target  text;
        BEGIN           
            IF character_length(code) = '6' AND otype = 'tehsil' THEN
              yearly_target = getyearlynewborn_targetpopulationpop(code,yearr,'tehsil'::text);
            ELSE
              yearly_target = getyearlynewborn_targetpopulationpop(code,yearr);
            END IF;           
            monthly_target =yearly_target::numeric / 12;
            RETURN monthly_target;
        END;
        $$;


ALTER FUNCTION public.getmonthlynewborn_targetpopulationpop(code character varying, yearr character varying, otype text) OWNER TO postgres;

--
-- Name: getmonthlytarget_specificyearr(text, integer, integer, integer, integer, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getmonthlytarget_specificyearr(code text, startyearr integer, sm integer, endyearr integer, em integer, otype text DEFAULT ''::text) RETURNS text
    LANGUAGE plpgsql
    AS $$
DECLARE
   	target_pop text;
    start_months integer;
       	BEGIN
       		target_pop=0;
            FOR i IN startyearr..endyearr LOOP  
				IF i=startyearr THEN 
					IF startyearr=endyearr THEN 
						start_months = (em-sm)+1; 
					ELSE 
						start_months = (12-sm)+1;
					END IF;
				ELSEIF i=endyearr THEN 
					start_months = em;
				END IF;
				IF i=startyearr THEN
					
		            IF character_length(code) = '6' AND otype = 'tehsil' THEN
		               target_pop:=target_pop::numeric+getmonthlynewborn_targetpopulationpop(code::character varying,startyearr::character varying,'tehsil'::character varying)::numeric*start_months;
		            ELSE
		               target_pop:=target_pop::numeric+getmonthlynewborn_targetpopulationpop(code::character varying,startyearr::character varying)::numeric*start_months;
		            END IF;
		          
				ELSEIF i=endyearr THEN 
					IF target_pop IS NULL THEN 
						target_pop:=0;
					ELSE						

			            IF character_length(code) = '6' AND otype = 'tehsil' THEN
			               target_pop:=target_pop::numeric+getmonthlynewborn_targetpopulationpop(code::character varying,endyearr::character varying,'tehsil'::character varying)::numeric*start_months;
			            ELSE
			               target_pop:=target_pop::numeric+getmonthlynewborn_targetpopulationpop(code::character varying,endyearr::character varying)::numeric*start_months;
			            END IF;
			          
					END IF;
				ELSE
					
		            IF character_length(code) = '6' AND otype = 'tehsil' THEN
		               target_pop:=target_pop::numeric+getmonthlynewborn_targetpopulationpop(code::character varying,i::character varying,'tehsil'::character varying)::numeric*12;
		            ELSE
		               target_pop:=target_pop::numeric+getmonthlynewborn_targetpopulationpop(code::character varying,i::character varying)::numeric*12;
		            END IF;
		            
				END IF;
			END LOOP;
            RETURN target_pop;
        END;
        $$;


ALTER FUNCTION public.getmonthlytarget_specificyearr(code text, startyearr integer, sm integer, endyearr integer, em integer, otype text) OWNER TO postgres;

--
-- Name: getmonthlytarget_specificyearrsurvivinginfants(text, text, integer, integer, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getmonthlytarget_specificyearrsurvivinginfants(ocode text, otype text, startyearr integer, sm integer, endyearr integer, em integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
	target_pop text;
	start_months integer;
   
	BEGIN
		target_pop=0;
		
		IF character_length(ocode) = '1' THEN
		   otype = 'province';
		END IF;
		IF character_length(ocode) = '3' THEN
		   otype = 'district';
		END IF;
		IF character_length(ocode) = '6' AND otype = 'tehsil' THEN
		   otype = 'tehsil';
		ELSEIF character_length(ocode) = '6' THEN
		   otype = 'facility';
		END IF;
		IF character_length(ocode) = '9' THEN
		   otype = 'unioncouncil';
		END IF;

		FOR i IN startyearr..endyearr LOOP
			IF i=startyearr THEN
				IF startyearr=endyearr THEN
					start_months = (em-sm)+1;
				ELSE
					start_months = (12-sm)+1;
				END IF;
			ELSEIF i = endyearr THEN 
				start_months = em;
			END IF;
			IF i = startyearr THEN
				target_pop := target_pop::numeric+getmonthly_survivinginfantspop(ocode,otype,startyearr::text)::numeric*start_months;
			ELSEIF i = endyearr THEN 
				IF target_pop IS NULL THEN 
					target_pop := 0;
				ELSE
					target_pop := target_pop::numeric+getmonthly_survivinginfantspop(ocode,otype,endyearr::text)::numeric*start_months;
				END IF;
			ELSE 
				target_pop := target_pop::numeric+getmonthly_survivinginfantspop(ocode,otype,i::text)::numeric*12;
			END IF;
		END LOOP;
	RETURN target_pop;
END;$$;


ALTER FUNCTION public.getmonthlytarget_specificyearrsurvivinginfants(ocode text, otype text, startyearr integer, sm integer, endyearr integer, em integer) OWNER TO postgres;

--
-- Name: getmonthlyvaccination(character varying, text, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getmonthlyvaccination(ffmonth character varying, code text, vaccineid integer) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
   vaccination integer;
   whereText text;
       BEGIN
            IF character_length(code) = '1' THEN
               whereText := 'procode';
            END IF;
            IF character_length(code) = '3' THEN
               whereText := 'distcode';
            END IF;
            IF character_length(code) = '6' THEN
               whereText := 'facode';
            END IF;
            IF character_length(code) = '9' THEN
               whereText := 'uncode';
            END IF;

            IF vaccineID = 1 OR vaccineID = 2 OR vaccineID = 13 THEN
                EXECUTE 'SELECT SUM(cri_r1_f'||vaccineID||')+SUM(cri_r2_f'||vaccineID||')+SUM(cri_r3_f'||vaccineID||')+SUM(cri_r4_f'||vaccineID||')+SUM(cri_r5_f'||vaccineID||')+SUM(cri_r6_f'||vaccineID||')+SUM(cri_r7_f'||vaccineID||')+SUM(cri_r8_f'||vaccineID||')+SUM(cri_r9_f'||vaccineID||')+SUM(cri_r10_f'||vaccineID||')+SUM(cri_r11_f'||vaccineID||')+SUM(cri_r12_f'||vaccineID||')+SUM(cri_r13_f'||vaccineID||')+SUM(cri_r14_f'||vaccineID||')+SUM(cri_r15_f'||vaccineID||')+SUM(cri_r16_f'||vaccineID||')+SUM(cri_r17_f'||vaccineID||')+SUM(cri_r18_f'||vaccineID||')+SUM(cri_r19_f'||vaccineID||')+SUM(cri_r20_f'||vaccineID||')+SUM(cri_r21_f'||vaccineID||')+SUM(cri_r22_f'||vaccineID||')+SUM(cri_r23_f'||vaccineID||')+SUM(cri_r24_f'||vaccineID||') FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO vaccination;           
            ELSIF vaccineID = 3 OR vaccineID = 4 OR vaccineID = 5 OR vaccineID = 6 THEN
                EXECUTE 'SELECT SUM(cri_r1_f3)+SUM(cri_r2_f3)+SUM(cri_r3_f3)+SUM(cri_r4_f3)+SUM(cri_r5_f3)+SUM(cri_r6_f3)+SUM(cri_r7_f3)+SUM(cri_r8_f3)+SUM(cri_r9_f3)+SUM(cri_r10_f3)+SUM(cri_r11_f3)+SUM(cri_r12_f3)+SUM(cri_r13_f3)+SUM(cri_r14_f3)+SUM(cri_r15_f3)+SUM(cri_r16_f3)+SUM(cri_r17_f3)+SUM(cri_r18_f3)+SUM(cri_r19_f3)+SUM(cri_r20_f3)+SUM(cri_r21_f3)+SUM(cri_r22_f3)+SUM(cri_r23_f3)+SUM(cri_r24_f3)+SUM(cri_r1_f4)+SUM(cri_r2_f4)+SUM(cri_r3_f4)+SUM(cri_r4_f4)+SUM(cri_r5_f4)+SUM(cri_r6_f4)+SUM(cri_r7_f4)+SUM(cri_r8_f4)+SUM(cri_r9_f4)+SUM(cri_r10_f4)+SUM(cri_r11_f4)+SUM(cri_r12_f4)+SUM(cri_r13_f4)+SUM(cri_r14_f4)+SUM(cri_r15_f4)+SUM(cri_r16_f4)+SUM(cri_r17_f4)+SUM(cri_r18_f4)+SUM(cri_r19_f4)+SUM(cri_r20_f4)+SUM(cri_r21_f4)+SUM(cri_r22_f4)+SUM(cri_r23_f4)+SUM(cri_r24_f4)+SUM(cri_r1_f5)+SUM(cri_r2_f5)+SUM(cri_r3_f5)+SUM(cri_r4_f5)+SUM(cri_r5_f5)+SUM(cri_r6_f5)+SUM(cri_r7_f5)+SUM(cri_r8_f5)+SUM(cri_r9_f5)+SUM(cri_r10_f5)+SUM(cri_r11_f5)+SUM(cri_r12_f5)+SUM(cri_r13_f5)+SUM(cri_r14_f5)+SUM(cri_r15_f5)+SUM(cri_r16_f5)+SUM(cri_r17_f5)+SUM(cri_r18_f5)+SUM(cri_r19_f5)+SUM(cri_r20_f5)+SUM(cri_r21_f5)+SUM(cri_r22_f5)+SUM(cri_r23_f5)+SUM(cri_r24_f5)+SUM(cri_r1_f6)+SUM(cri_r2_f6)+SUM(cri_r3_f6)+SUM(cri_r4_f6)+SUM(cri_r5_f6)+SUM(cri_r6_f6)+SUM(cri_r7_f6)+SUM(cri_r8_f6)+SUM(cri_r9_f6)+SUM(cri_r10_f6)+SUM(cri_r11_f6)+SUM(cri_r12_f6)+SUM(cri_r13_f6)+SUM(cri_r14_f6)+SUM(cri_r15_f6)+SUM(cri_r16_f6)+SUM(cri_r17_f6)+SUM(cri_r18_f6)+SUM(cri_r19_f6)+SUM(cri_r20_f6)+SUM(cri_r21_f6)+SUM(cri_r22_f6)+SUM(cri_r23_f6)+SUM(cri_r24_f6) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO vaccination;
            ELSIF vaccineID = 7 OR vaccineID = 8 OR vaccineID = 9 THEN
                EXECUTE 'SELECT SUM(cri_r1_f7)+SUM(cri_r2_f7)+SUM(cri_r3_f7)+SUM(cri_r4_f7)+SUM(cri_r5_f7)+SUM(cri_r6_f7)+SUM(cri_r7_f7)+SUM(cri_r8_f7)+SUM(cri_r9_f7)+SUM(cri_r10_f7)+SUM(cri_r11_f7)+SUM(cri_r12_f7)+SUM(cri_r13_f7)+SUM(cri_r14_f7)+SUM(cri_r15_f7)+SUM(cri_r16_f7)+SUM(cri_r17_f7)+SUM(cri_r18_f7)+SUM(cri_r19_f7)+SUM(cri_r20_f7)+SUM(cri_r21_f7)+SUM(cri_r22_f7)+SUM(cri_r23_f7)+SUM(cri_r24_f7)+SUM(cri_r1_f8)+SUM(cri_r2_f8)+SUM(cri_r3_f8)+SUM(cri_r4_f8)+SUM(cri_r5_f8)+SUM(cri_r6_f8)+SUM(cri_r7_f8)+SUM(cri_r8_f8)+SUM(cri_r9_f8)+SUM(cri_r10_f8)+SUM(cri_r11_f8)+SUM(cri_r12_f8)+SUM(cri_r13_f8)+SUM(cri_r14_f8)+SUM(cri_r15_f8)+SUM(cri_r16_f8)+SUM(cri_r17_f8)+SUM(cri_r18_f8)+SUM(cri_r19_f8)+SUM(cri_r20_f8)+SUM(cri_r21_f8)+SUM(cri_r22_f8)+SUM(cri_r23_f8)+SUM(cri_r24_f8)+SUM(cri_r1_f9)+SUM(cri_r2_f9)+SUM(cri_r3_f9)+SUM(cri_r4_f9)+SUM(cri_r5_f9)+SUM(cri_r6_f9)+SUM(cri_r7_f9)+SUM(cri_r8_f9)+SUM(cri_r9_f9)+SUM(cri_r10_f9)+SUM(cri_r11_f9)+SUM(cri_r12_f9)+SUM(cri_r13_f9)+SUM(cri_r14_f9)+SUM(cri_r15_f9)+SUM(cri_r16_f9)+SUM(cri_r17_f9)+SUM(cri_r18_f9)+SUM(cri_r19_f9)+SUM(cri_r20_f9)+SUM(cri_r21_f9)+SUM(cri_r22_f9)+SUM(cri_r23_f9)+SUM(cri_r24_f9) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO vaccination;
            ELSIF vaccineID = 10 OR vaccineID = 11 OR vaccineID = 12 THEN
                EXECUTE 'SELECT SUM(cri_r1_f10)+SUM(cri_r2_f10)+SUM(cri_r3_f10)+SUM(cri_r4_f10)+SUM(cri_r5_f10)+SUM(cri_r6_f10)+SUM(cri_r7_f10)+SUM(cri_r8_f10)+SUM(cri_r9_f10)+SUM(cri_r10_f10)+SUM(cri_r11_f10)+SUM(cri_r12_f10)+SUM(cri_r13_f10)+SUM(cri_r14_f10)+SUM(cri_r15_f10)+SUM(cri_r16_f10)+SUM(cri_r17_f10)+SUM(cri_r18_f10)+SUM(cri_r19_f10)+SUM(cri_r20_f10)+SUM(cri_r21_f10)+SUM(cri_r22_f10)+SUM(cri_r23_f10)+SUM(cri_r24_f10)+SUM(cri_r1_f11)+SUM(cri_r2_f11)+SUM(cri_r3_f11)+SUM(cri_r4_f11)+SUM(cri_r5_f11)+SUM(cri_r6_f11)+SUM(cri_r7_f11)+SUM(cri_r8_f11)+SUM(cri_r9_f11)+SUM(cri_r10_f11)+SUM(cri_r11_f11)+SUM(cri_r12_f11)+SUM(cri_r13_f11)+SUM(cri_r14_f11)+SUM(cri_r15_f11)+SUM(cri_r16_f11)+SUM(cri_r17_f11)+SUM(cri_r18_f11)+SUM(cri_r19_f11)+SUM(cri_r20_f11)+SUM(cri_r21_f11)+SUM(cri_r22_f11)+SUM(cri_r23_f11)+SUM(cri_r24_f11)+SUM(cri_r1_f12)+SUM(cri_r2_f12)+SUM(cri_r3_f12)+SUM(cri_r4_f12)+SUM(cri_r5_f12)+SUM(cri_r6_f12)+SUM(cri_r7_f12)+SUM(cri_r8_f12)+SUM(cri_r9_f12)+SUM(cri_r10_f12)+SUM(cri_r11_f12)+SUM(cri_r12_f12)+SUM(cri_r13_f12)+SUM(cri_r14_f12)+SUM(cri_r15_f12)+SUM(cri_r16_f12)+SUM(cri_r17_f12)+SUM(cri_r18_f12)+SUM(cri_r19_f12)+SUM(cri_r20_f12)+SUM(cri_r21_f12)+SUM(cri_r22_f12)+SUM(cri_r23_f12)+SUM(cri_r24_f12) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO vaccination;
            ELSIF vaccineID = 16 OR vaccineID = 18 THEN
                EXECUTE 'SELECT SUM(cri_r1_f16)+SUM(cri_r2_f16)+SUM(cri_r3_f16)+SUM(cri_r4_f16)+SUM(cri_r5_f16)+SUM(cri_r6_f16)+SUM(cri_r7_f16)+SUM(cri_r8_f16)+SUM(cri_r9_f16)+SUM(cri_r10_f16)+SUM(cri_r11_f16)+SUM(cri_r12_f16)+SUM(cri_r13_f16)+SUM(cri_r14_f16)+SUM(cri_r15_f16)+SUM(cri_r16_f16)+SUM(cri_r17_f16)+SUM(cri_r18_f16)+SUM(cri_r19_f16)+SUM(cri_r20_f16)+SUM(cri_r21_f16)+SUM(cri_r22_f16)+SUM(cri_r23_f16)+SUM(cri_r24_f16)+SUM(cri_r1_f18)+SUM(cri_r2_f18)+SUM(cri_r3_f18)+SUM(cri_r4_f18)+SUM(cri_r5_f18)+SUM(cri_r6_f18)+SUM(cri_r7_f18)+SUM(cri_r8_f18)+SUM(cri_r9_f18)+SUM(cri_r10_f18)+SUM(cri_r11_f18)+SUM(cri_r12_f18)+SUM(cri_r13_f18)+SUM(cri_r14_f18)+SUM(cri_r15_f18)+SUM(cri_r16_f18)+SUM(cri_r17_f18)+SUM(cri_r18_f18)+SUM(cri_r19_f18)+SUM(cri_r20_f18)+SUM(cri_r21_f18)+SUM(cri_r22_f18)+SUM(cri_r23_f18)+SUM(cri_r24_f18) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO vaccination;
            ELSIF vaccineID = 14 OR vaccineID = 15 THEN
          EXECUTE 'SELECT SUM(cri_r1_f14)+SUM(cri_r2_f14)+SUM(cri_r3_f14)+SUM(cri_r4_f14)+SUM(cri_r5_f14)+SUM(cri_r6_f14)+SUM(cri_r7_f14)+SUM(cri_r8_f14)+SUM(cri_r9_f14)+SUM(cri_r10_f14)+SUM(cri_r11_f14)+SUM(cri_r12_f14)+SUM(cri_r13_f14)+SUM(cri_r14_f14)+SUM(cri_r15_f14)+SUM(cri_r16_f14)+SUM(cri_r17_f14)+SUM(cri_r18_f14)+SUM(cri_r19_f14)+SUM(cri_r20_f14)+SUM(cri_r21_f14)+SUM(cri_r22_f14)+SUM(cri_r23_f14)+SUM(cri_r24_f16)+SUM(cri_r1_f18)+SUM(cri_r2_f18)+SUM(cri_r3_f18)+SUM(cri_r4_f18)+SUM(cri_r5_f18)+SUM(cri_r6_f18)+SUM(cri_r7_f18)+SUM(cri_r8_f18)+SUM(cri_r9_f18)+SUM(cri_r10_f18)+SUM(cri_r11_f18)+SUM(cri_r12_f18)+SUM(cri_r13_f18)+SUM(cri_r14_f18)+SUM(cri_r15_f18)+SUM(cri_r16_f18)+SUM(cri_r17_f18)+SUM(cri_r18_f18)+SUM(cri_r19_f18)+SUM(cri_r20_f18)+SUM(cri_r21_f18)+SUM(cri_r22_f18)+SUM(cri_r23_f18)+SUM(cri_r24_f18) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO vaccination;
            ELSE 
                vaccination := 0; 
            END IF;
            RETURN vaccination;
       END;$$;


ALTER FUNCTION public.getmonthlyvaccination(ffmonth character varying, code text, vaccineid integer) OWNER TO postgres;

--
-- Name: getnewborn(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getnewborn(ocode text, otype text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        totpop integer;
    BEGIN
        SELECT round((getpopulation(ocode,otype)::numeric*3.533) / 100) into totpop;
	
        RETURN totpop;
    END;

--DECLARE
  --      totpop integer;
    --BEGIN
      --  SELECT round((getpopulation(ocode,otype)::integer*3.533) / 100,2) into totpop;
	
        --RETURN round(totpop);
    --END;$$;


ALTER FUNCTION public.getnewborn(ocode text, otype text) OWNER TO postgres;

--
-- Name: getnewbornpop(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getnewbornpop(ocode text, otype text, yearr text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        totpop integer;
    BEGIN
        SELECT round((getpopulationpop(ocode,otype,yearr)::numeric*get_indicator_periodic_multiplier_dist_target('newborn',yearr,ocode)) / 100) into totpop;
    
        RETURN totpop;
    END;$$;


ALTER FUNCTION public.getnewbornpop(ocode text, otype text, yearr text) OWNER TO postgres;

--
-- Name: getnewbornpop_old(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getnewbornpop_old(ocode text, otype text, yearr text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        totpop integer;
    BEGIN
        SELECT round((getpopulationpop(ocode,otype,yearr)::numeric*3.533) / 100) into totpop;
	
        RETURN totpop;
    END;$$;


ALTER FUNCTION public.getnewbornpop_old(ocode text, otype text, yearr text) OWNER TO postgres;

--
-- Name: getperiodicpopulation(text, text, integer, integer, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getperiodicpopulation(ocode text, otype text, startyearr integer, sm integer, endyearr integer, em integer) RETURNS numeric
    LANGUAGE plpgsql
    AS $$DECLARE
	target_pop numeric;
	start_months integer;
	BEGIN
		target_pop=0;
		
		FOR i IN startyearr..endyearr LOOP  
			IF i=startyearr THEN 
				IF startyearr=endyearr THEN 
					start_months = (em-sm)+1; 
				ELSE 
					start_months = (12-sm)+1;
				END IF;
			ELSEIF i=endyearr THEN 
				start_months = em;
			END IF;
			IF i=startyearr THEN 
				target_pop:=target_pop::numeric+getpopulationpop(ocode::character varying,otype::character varying,startyearr::character varying)::numeric/12*start_months;
			ELSEIF i=endyearr THEN 
				IF target_pop IS NULL THEN 
					target_pop:=0;
				ELSE
					target_pop:=target_pop::numeric+getpopulationpop(ocode::character varying,otype::character varying,endyearr::character varying)::numeric/12*start_months;
				END IF;
			ELSE 
				target_pop:=target_pop::numeric+getpopulationpop(ocode::character varying,otype::character varying,i::character varying)::numeric;
			END IF;
		END LOOP;
	RETURN round(target_pop);
END;$$;


ALTER FUNCTION public.getperiodicpopulation(ocode text, otype text, startyearr integer, sm integer, endyearr integer, em integer) OWNER TO postgres;

--
-- Name: getplw(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getplw(ocode text, otype text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        totpop int;
    BEGIN
        SELECT round(getnewborn(ocode,otype)::numeric * 1.02) into totpop;
	
        RETURN totpop;
    END;$$;


ALTER FUNCTION public.getplw(ocode text, otype text) OWNER TO postgres;

--
-- Name: getplwpop(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getplwpop(ocode text, otype text, yearr text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        totpop int;
    BEGIN
        SELECT round((getnewbornpop(ocode,otype,yearr)::numeric * get_indicator_periodic_multiplier_dist_target('plwomen',yearr,ocode))) into totpop;
    
        RETURN totpop;
    END;$$;


ALTER FUNCTION public.getplwpop(ocode text, otype text, yearr text) OWNER TO postgres;

--
-- Name: getplwpop_old(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getplwpop_old(ocode text, otype text, yearr text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        totpop int;
    BEGIN
        SELECT round(getnewbornpop(ocode,otype,yearr)::numeric * 1.02) into totpop;
	
        RETURN totpop;
    END;$$;


ALTER FUNCTION public.getplwpop_old(ocode text, otype text, yearr text) OWNER TO postgres;

--
-- Name: getpopulation(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getpopulation(ocode text, otype text) RETURNS text
    LANGUAGE plpgsql
    AS $$  DECLARE
        pop text;
    BEGIN
	if otype='province' then
	  SELECT population into pop from province_population where procode=ocode;
	end if;
	if otype='district' then
	  SELECT population into pop from districts where distcode=ocode;
	end if;
	if otype='tehsil' then
	  SELECT population into pop from tehsil where tcode=ocode;
	end if;
	if otype='unioncouncil' then
	  SELECT population into pop from unioncouncil where uncode=ocode;
	end if;
	if otype='facility' then
	  SELECT catchment_area_pop into pop from facilities where facode=ocode and hf_type='e';
	end if;
        if otype='technician' then
	  SELECT catch_area_pop into pop from techniciandb where techniciancode=ocode;
	end if;

        RETURN pop;
    END;
  $$;


ALTER FUNCTION public.getpopulation(ocode text, otype text) OWNER TO postgres;

--
-- Name: getpopulationpop(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getpopulationpop(ocode text, otype text, yearr text) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
        pop text;
    BEGIN
	if otype='province' then
	  SELECT population into pop from province_population where procode=ocode and year=yearr;
	end if;
	if otype='district' then
	  SELECT population into pop from districts_population where distcode=ocode and year=yearr;
	end if;
	if otype='tehsil' then
	  SELECT population into pop from tehsil_population where tcode=ocode and year=yearr;
	end if;
	if otype='unioncouncil' then
	  SELECT population into pop from unioncouncil_population where uncode=ocode and year=yearr;
	end if;
	if otype='facility' then
	  SELECT population into pop from facilities_population where facode=ocode and year=yearr;
	end if;
        if otype='technician' then
	  SELECT catch_area_pop into pop from techniciandb where techniciancode=ocode;
	end if;

        RETURN pop;
    END;$$;


ALTER FUNCTION public.getpopulationpop(ocode text, otype text, yearr text) OWNER TO postgres;

--
-- Name: getpriority(date, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getpriority(expiry date, vvmstage text) RETURNS text
    LANGUAGE plpgsql
    AS $_$DECLARE
     outstr text;
   BEGIN
SELECT 
case 
 when $1<CURRENT_DATE OR $2='3' OR $2='4' then 'Unusable'
 when ($1>=CURRENT_DATE and $1<=(CURRENT_DATE+interval '3 months')) OR $2='2' then 'P1' 
 when ($1>=(CURRENT_DATE+interval '3 months') and $1<=(CURRENT_DATE+interval '12 months')) OR $2='1' then 'P2' 
 when ($1>(CURRENT_DATE+interval '12 months')) OR $2='1' then 'P3' else ' ' end 
into outstr;
RETURN outstr;
   END$_$;


ALTER FUNCTION public.getpriority(expiry date, vvmstage text) OWNER TO postgres;

--
-- Name: getsubtypename(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getsubtypename(code text) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
        name text;
    BEGIN
	SELECT title into name from hr_sub_types where type_id=code;
        RETURN name;
    END;$$;


ALTER FUNCTION public.getsubtypename(code text) OWNER TO postgres;

--
-- Name: getsurvivinginfants(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getsurvivinginfants(ocode text, otype text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        totpop int;
    BEGIN
        SELECT round((getnewborn(ocode,otype)::integer * 94.2) / 100) into totpop;
	
        RETURN totpop;
    END;

--DECLARE
  --      totpop int;
    --BEGIN
      --  SELECT round((getnewborn(ocode,otype)::integer * 94.2) / 100,2) into totpop;
	
        --RETURN totpop;
   -- END;$$;


ALTER FUNCTION public.getsurvivinginfants(ocode text, otype text) OWNER TO postgres;

--
-- Name: getsurvivinginfantspop(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getsurvivinginfantspop(ocode text, otype text, yearr text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        totpop int;
    BEGIN
        SELECT round((getnewbornpop(ocode,otype,yearr)::integer * get_indicator_periodic_multiplier_dist_target('survivinginfants',yearr,ocode)) / 100) into totpop;
    
        RETURN totpop;
    END;$$;


ALTER FUNCTION public.getsurvivinginfantspop(ocode text, otype text, yearr text) OWNER TO postgres;

--
-- Name: getsurvivinginfantspop_old(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getsurvivinginfantspop_old(ocode text, otype text, yearr text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        totpop int;
    BEGIN
        SELECT round((getnewbornpop(ocode,otype,yearr)::integer * 94.2) / 100) into totpop;
	
        RETURN totpop;
    END;$$;


ALTER FUNCTION public.getsurvivinginfantspop_old(ocode text, otype text, yearr text) OWNER TO postgres;

--
-- Name: getyearly_plwomen_target(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getyearly_plwomen_target(code character varying, yearr character varying) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
   yearly_target text;
   pl_target text;
   population text;
       BEGIN
            yearly_target = getyearlynewborn_targetpopulation(code,'');
            pl_target = yearly_target::numeric * 1.02 ;
            RETURN pl_target;
       END;$$;


ALTER FUNCTION public.getyearly_plwomen_target(code character varying, yearr character varying) OWNER TO postgres;

--
-- Name: FUNCTION getyearly_plwomen_target(code character varying, yearr character varying); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION getyearly_plwomen_target(code character varying, yearr character varying) IS 'year functionality is not yet implemented. Later on target monthly population will be based on year. ';


--
-- Name: getyearly_plwomen_targetpop(character varying, character varying, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getyearly_plwomen_targetpop(code character varying, yearr character varying, otype text DEFAULT ''::text) RETURNS text
    LANGUAGE plpgsql
    AS $$
DECLARE
    yearly_target text;
    pl_target text;
    population text;
        BEGIN
            
            IF character_length(code) = '6' AND otype = 'tehsil' THEN
               yearly_target = getyearlynewborn_targetpopulationpop(code,yearr,'tehsil'::text);           
            ELSE
               yearly_target = getyearlynewborn_targetpopulationpop(code,yearr);
            END IF;  

            pl_target = yearly_target::numeric * get_indicator_periodic_multiplier_dist_target('plwomen',yearr,code);
            RETURN pl_target;
        END;
        $$;


ALTER FUNCTION public.getyearly_plwomen_targetpop(code character varying, yearr character varying, otype text) OWNER TO postgres;

--
-- Name: getyearly_plwomen_targetpop_tp(character varying, character varying, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getyearly_plwomen_targetpop_tp(code character varying, yearr character varying, otype text DEFAULT ''::text) RETURNS text
    LANGUAGE plpgsql
    AS $$
DECLARE
    yearly_target text;
    pl_target text;
    population text;
        BEGIN
            IF character_length(code) = '1' THEN
                --yearly_target = getyearlynewborn_targetpopulationpop(code,yearr);
                yearly_target = getpopulationpop (code::text, 'province'::text, yearr::text);
            END IF;
            IF character_length(code) = '3' THEN
                --yearly_target = getyearlynewborn_targetpopulationpop(code,yearr);
                yearly_target = getpopulationpop (code::text, 'district'::text, yearr::text);
            END IF;

            IF character_length(code) = '6' AND otype = 'tehsil' THEN
                --yearly_target = getyearlynewborn_targetpopulationpop(code,yearr,'tehsil'::text);
                yearly_target = getpopulationpop (code::text, 'tehsil'::text, yearr::text);
            ELSEIF character_length(code) = '6' THEN
                --yearly_target = getyearlynewborn_targetpopulationpop(code,yearr);
                yearly_target = getpopulationpop (code::text, 'facility'::text, yearr::text);
            END IF;  

            IF character_length(code) = '9' THEN
               --yearly_target = getyearlynewborn_targetpopulationpop(code,yearr);
               yearly_target = getpopulationpop (code::text, 'unioncouncil'::text, yearr::text);
            END IF;
            pl_target = (yearly_target::numeric * get_indicator_periodic_multiplier_dist_target('plwomen',yearr,code) ) / 100;
            RETURN pl_target;
        END;
        $$;


ALTER FUNCTION public.getyearly_plwomen_targetpop_tp(code character varying, yearr character varying, otype text) OWNER TO postgres;

--
-- Name: getyearlynewborn_targetpopulation(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getyearlynewborn_targetpopulation(code character varying, yearr character varying) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
   target text;
   population text;
       BEGIN
            IF character_length(code) = '1' THEN
               population = getpopulation (code, 'province');
            END IF;
            IF character_length(code) = '3' THEN
               population = getpopulation (code, 'district');
            END IF;
            IF character_length(code) = '6' THEN
               population = getpopulation (code, 'facility');
            END IF;
            IF character_length(code) = '9' THEN
               population = getpopulation (code, 'unioncouncil');
            END IF;
            target = ( population::numeric * 3.533 ) / 100;
            RETURN target;
       END;$$;


ALTER FUNCTION public.getyearlynewborn_targetpopulation(code character varying, yearr character varying) OWNER TO postgres;

--
-- Name: FUNCTION getyearlynewborn_targetpopulation(code character varying, yearr character varying); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION getyearlynewborn_targetpopulation(code character varying, yearr character varying) IS 'year functionality is not yet implemented. Later on population will be based on year. ';


--
-- Name: getyearlynewborn_targetpopulationpop(character varying, character varying, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION getyearlynewborn_targetpopulationpop(code character varying, yearr character varying, otype text DEFAULT ''::text) RETURNS text
    LANGUAGE plpgsql
    AS $$
DECLARE
    target text;
    population text;
        BEGIN
            IF character_length(code) = '1' THEN
              population = getpopulationpop (code::text, 'province'::text, yearr::text);
            END IF;
            IF character_length(code) = '3' THEN
               population = getpopulationpop (code::text, 'district'::text, yearr::text);
            END IF;

            IF character_length(code) = '6' AND otype = 'tehsil' THEN
               population = getpopulationpop (code::text, 'tehsil'::text, yearr::text);           
            ELSEIF character_length(code) = '6' THEN
               population = getpopulationpop (code::text, 'facility'::text, yearr::text);
            END IF;  

            IF character_length(code) = '9' THEN
               population = getpopulationpop (code::text, 'unioncouncil'::text, yearr::text);
            END IF;
            target = ( population::numeric * get_indicator_periodic_multiplier_dist_target('newborn',yearr,code) ) / 100;
            RETURN target;
        END;
        $$;


ALTER FUNCTION public.getyearlynewborn_targetpopulationpop(code character varying, yearr character varying, otype text) OWNER TO postgres;

--
-- Name: gtpb_divide(integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION gtpb_divide(integer, integer) RETURNS integer
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT $1 / NULLIF($2,0);$_$;


ALTER FUNCTION public.gtpb_divide(integer, integer) OWNER TO postgres;

--
-- Name: gtpb_divide(double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION gtpb_divide(double precision, double precision) RETURNS double precision
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT $1 / NULLIF($2,0);$_$;


ALTER FUNCTION public.gtpb_divide(double precision, double precision) OWNER TO postgres;

--
-- Name: gtpb_divide(double precision, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION gtpb_divide(double precision, integer) RETURNS double precision
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT $1 / NULLIF($2,0);$_$;


ALTER FUNCTION public.gtpb_divide(double precision, integer) OWNER TO postgres;

--
-- Name: gtpb_divide(integer, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION gtpb_divide(integer, double precision) RETURNS double precision
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$SELECT $1 / NULLIF($2,0);$_$;


ALTER FUNCTION public.gtpb_divide(integer, double precision) OWNER TO postgres;

--
-- Name: hf_total_submitted_count(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION hf_total_submitted_count(fmonthh character varying, distcodee character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
   total_submitted_rep integer;
   
       BEGIN

            EXECUTE 'SELECT COUNT(*) FROM epi_consumption_master WHERE fmonth = '''||fmonthh||''' and distcode= '''||distcodee||''' and is_compiled= 1 ' INTO total_submitted_rep;
          
            RETURN total_submitted_rep;
       END;$$;


ALTER FUNCTION public.hf_total_submitted_count(fmonthh character varying, distcodee character varying) OWNER TO postgres;

--
-- Name: FUNCTION hf_total_submitted_count(fmonthh character varying, distcodee character varying); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION hf_total_submitted_count(fmonthh character varying, distcodee character varying) IS 'count of total HF report submiited in epi_consumption_master  table district wise as parameter and month parameter';


--
-- Name: hf_total_submitted_count(character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION hf_total_submitted_count(fmonthh character varying, columnname character varying, code character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
   total_submitted_rep integer;
   
       BEGIN

            EXECUTE 'SELECT COUNT(*) FROM epi_consumption_master WHERE fmonth = '''||fmonthh||''' and '||columnname||' like   '''||code||'%'''  INTO total_submitted_rep;
          
            RETURN total_submitted_rep;
       END;$$;


ALTER FUNCTION public.hf_total_submitted_count(fmonthh character varying, columnname character varying, code character varying) OWNER TO postgres;

--
-- Name: hr_name(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION hr_name(hr_code text) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
        hrname text;
    BEGIN
	SELECT name into hrname from hr_db where code=hr_code;
        RETURN hrname ;
    END;$$;


ALTER FUNCTION public.hr_name(hr_code text) OWNER TO postgres;

--
-- Name: itemcatname(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION itemcatname(categoryid integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
        catname text;
    BEGIN
	SELECT item_category_name into catname from epi_item_categories where pk_id=categoryid;
        RETURN catname;
    END;$$;


ALTER FUNCTION public.itemcatname(categoryid integer) OWNER TO postgres;

--
-- Name: FUNCTION itemcatname(categoryid integer); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION itemcatname(categoryid integer) IS 'This function will return item category name from item_category_name table against given id';


--
-- Name: itemunitname(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION itemunitname(unitid integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
        unitname text;
    BEGIN
	SELECT item_unit_name into unitname from epi_item_units where pk_id=unitid;
        RETURN unitname;
    END;$$;


ALTER FUNCTION public.itemunitname(unitid integer) OWNER TO postgres;

--
-- Name: makername(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION makername(mkcode integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
     mkname text;
   BEGIN
    SELECT make_name into mkname from epi_cc_makes where pk_id=mkcode;
   RETURN mkname;
   END$$;


ALTER FUNCTION public.makername(mkcode integer) OWNER TO postgres;

--
-- Name: manufacturername(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION manufacturername(mftcode integer) RETURNS text
    LANGUAGE plpgsql
    AS $$ DECLARE
     mftname text;
   BEGIN
    SELECT name into mftname from epi_manufacturer where id=mftcode;
   RETURN mftname;
   END$$;


ALTER FUNCTION public.manufacturername(mftcode integer) OWNER TO postgres;

--
-- Name: modelname(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION modelname(mdcode integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
     mdname text;
   BEGIN
    SELECT model_name into mdname from epi_cc_models where pk_id=mdcode;
   RETURN mdname;
   END$$;


ALTER FUNCTION public.modelname(mdcode integer) OWNER TO postgres;

--
-- Name: monthly_dropout_rate(character varying, character varying, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION monthly_dropout_rate(ffmonth character varying, code character varying, dropout_type text) RETURNS double precision
    LANGUAGE plpgsql
    AS $$DECLARE
   rate double precision;
   whereText text;
   firstdose_given integer;
   seconddose_given integer;

       BEGIN
            IF character_length(code) = '1' THEN
                whereText := 'procode';
            ELSIF character_length(code) = '3' THEN
                whereText := 'distcode';
            ELSIF character_length(code) = '6' THEN
                whereText := 'facode';
            ELSIF character_length(code) = '9' THEN
                whereText := 'uncode';
            ELSE
                return 0;
            END IF;
            
            IF dropout_type = 'penta1-measles1' THEN
                EXECUTE 'SELECT SUM(cri_r1_f7)+SUM(cri_r2_f7)+SUM(cri_r3_f7)+SUM(cri_r4_f7)+SUM(cri_r5_f7)+SUM(cri_r6_f7)+SUM(cri_r7_f7)+SUM(cri_r8_f7)+SUM(cri_r9_f7)+SUM(cri_r10_f7)+SUM(cri_r11_f7)+SUM(cri_r12_f7)+SUM(cri_r13_f7)+SUM(cri_r14_f7)+SUM(cri_r15_f7)+SUM(cri_r16_f7)+SUM(cri_r17_f7)+SUM(cri_r18_f7)+SUM(cri_r19_f7)+SUM(cri_r20_f7)+SUM(cri_r21_f7)+SUM(cri_r22_f7)+SUM(cri_r23_f7)+SUM(cri_r24_f7) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO firstdose_given;
                EXECUTE 'SELECT SUM(cri_r1_f16)+SUM(cri_r2_f16)+SUM(cri_r3_f16)+SUM(cri_r4_f16)+SUM(cri_r5_f16)+SUM(cri_r6_f16)+SUM(cri_r7_f16)+SUM(cri_r8_f16)+SUM(cri_r9_f16)+SUM(cri_r10_f16)+SUM(cri_r11_f16)+SUM(cri_r12_f16)+SUM(cri_r13_f16)+SUM(cri_r14_f16)+SUM(cri_r15_f16)+SUM(cri_r16_f16)+SUM(cri_r17_f16)+SUM(cri_r18_f16)+SUM(cri_r19_f16)+SUM(cri_r20_f16)+SUM(cri_r21_f16)+SUM(cri_r22_f16)+SUM(cri_r23_f16)+SUM(cri_r24_f16) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO seconddose_given;
            ELSIF dropout_type = 'penta1-penta3' THEN
                EXECUTE 'SELECT SUM(cri_r1_f7)+SUM(cri_r2_f7)+SUM(cri_r3_f7)+SUM(cri_r4_f7)+SUM(cri_r5_f7)+SUM(cri_r6_f7)+SUM(cri_r7_f7)+SUM(cri_r8_f7)+SUM(cri_r9_f7)+SUM(cri_r10_f7)+SUM(cri_r11_f7)+SUM(cri_r12_f7)+SUM(cri_r13_f7)+SUM(cri_r14_f7)+SUM(cri_r15_f7)+SUM(cri_r16_f7)+SUM(cri_r17_f7)+SUM(cri_r18_f7)+SUM(cri_r19_f7)+SUM(cri_r20_f7)+SUM(cri_r21_f7)+SUM(cri_r22_f7)+SUM(cri_r23_f7)+SUM(cri_r24_f7) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO firstdose_given;
                EXECUTE 'SELECT SUM(cri_r1_f9)+SUM(cri_r2_f9)+SUM(cri_r3_f9)+SUM(cri_r4_f9)+SUM(cri_r5_f9)+SUM(cri_r6_f9)+SUM(cri_r7_f9)+SUM(cri_r8_f9)+SUM(cri_r9_f9)+SUM(cri_r10_f9)+SUM(cri_r11_f9)+SUM(cri_r12_f9)+SUM(cri_r13_f9)+SUM(cri_r14_f9)+SUM(cri_r15_f9)+SUM(cri_r16_f9)+SUM(cri_r17_f9)+SUM(cri_r18_f9)+SUM(cri_r19_f9)+SUM(cri_r20_f9)+SUM(cri_r21_f9)+SUM(cri_r22_f9)+SUM(cri_r23_f9)+SUM(cri_r24_f9) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO seconddose_given;
            ELSIF dropout_type = 'measles1-measles2' THEN
                EXECUTE 'SELECT SUM(cri_r1_f16)+SUM(cri_r2_f16)+SUM(cri_r3_f16)+SUM(cri_r4_f16)+SUM(cri_r5_f16)+SUM(cri_r6_f16)+SUM(cri_r7_f16)+SUM(cri_r8_f16)+SUM(cri_r9_f16)+SUM(cri_r10_f16)+SUM(cri_r11_f16)+SUM(cri_r12_f16)+SUM(cri_r13_f16)+SUM(cri_r14_f16)+SUM(cri_r15_f16)+SUM(cri_r16_f16)+SUM(cri_r17_f16)+SUM(cri_r18_f16)+SUM(cri_r19_f16)+SUM(cri_r20_f16)+SUM(cri_r21_f16)+SUM(cri_r22_f16)+SUM(cri_r23_f16)+SUM(cri_r24_f16) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO firstdose_given;
                EXECUTE 'SELECT SUM(cri_r1_f18)+SUM(cri_r2_f18)+SUM(cri_r3_f18)+SUM(cri_r4_f18)+SUM(cri_r5_f18)+SUM(cri_r6_f18)+SUM(cri_r7_f18)+SUM(cri_r8_f18)+SUM(cri_r9_f18)+SUM(cri_r10_f18)+SUM(cri_r11_f18)+SUM(cri_r12_f18)+SUM(cri_r13_f18)+SUM(cri_r14_f18)+SUM(cri_r15_f18)+SUM(cri_r16_f18)+SUM(cri_r17_f18)+SUM(cri_r18_f18)+SUM(cri_r19_f18)+SUM(cri_r20_f18)+SUM(cri_r21_f18)+SUM(cri_r22_f18)+SUM(cri_r23_f18)+SUM(cri_r24_f18) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO seconddose_given;
            ELSIF dropout_type = 'tt1-tt2' THEN
                EXECUTE 'SELECT SUM(ttri_r1_f1)+SUM(ttri_r2_f1)+SUM(ttri_r3_f1)+SUM(ttri_r4_f1)+SUM(ttri_r5_f1)+SUM(ttri_r6_f1)+SUM(ttri_r7_f1)+SUM(ttri_r8_f1) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO firstdose_given;
                EXECUTE 'SELECT SUM(ttri_r1_f2)+SUM(ttri_r2_f2)+SUM(ttri_r3_f2)+SUM(ttri_r4_f2)+SUM(ttri_r5_f2)+SUM(ttri_r6_f2)+SUM(ttri_r7_f2)+SUM(ttri_r8_f2) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO seconddose_given;
            ELSIF dropout_type = 'rota1-rota2' THEN
		EXECUTE 'SELECT SUM(cri_r1_f14)+SUM(cri_r2_f14)+SUM(cri_r3_f14)+SUM(cri_r4_f14)+SUM(cri_r5_f14)+SUM(cri_r6_f14)+SUM(cri_r7_f14)+SUM(cri_r8_f14)+SUM(cri_r9_f14)+SUM(cri_r10_f14)+SUM(cri_r11_f14)+SUM(cri_r12_f14)+SUM(cri_r13_f14)+SUM(cri_r14_f14)+SUM(cri_r15_f14)+SUM(cri_r16_f14)+SUM(cri_r17_f14)+SUM(cri_r18_f14)+SUM(cri_r19_f14)+SUM(cri_r20_f14)+SUM(cri_r21_f14)+SUM(cri_r22_f14)+SUM(cri_r23_f14)+SUM(cri_r24_f14) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO firstdose_given;
		EXECUTE 'SELECT SUM(cri_r1_f15)+SUM(cri_r2_f15)+SUM(cri_r3_f15)+SUM(cri_r4_f15)+SUM(cri_r5_f15)+SUM(cri_r6_f15)+SUM(cri_r7_f15)+SUM(cri_r8_f15)+SUM(cri_r9_f15)+SUM(cri_r10_f15)+SUM(cri_r11_f15)+SUM(cri_r12_f15)+SUM(cri_r13_f15)+SUM(cri_r14_f15)+SUM(cri_r15_f15)+SUM(cri_r16_f15)+SUM(cri_r17_f15)+SUM(cri_r18_f15)+SUM(cri_r19_f15)+SUM(cri_r20_f15)+SUM(cri_r21_f15)+SUM(cri_r22_f15)+SUM(cri_r23_f15)+SUM(cri_r24_f15) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO seconddose_given;
            ELSIF dropout_type = 'bcg-measles1' THEN
		EXECUTE 'SELECT SUM(cri_r1_f1)+SUM(cri_r2_f1)+SUM(cri_r3_f1)+SUM(cri_r4_f1)+SUM(cri_r5_f1)+SUM(cri_r6_f1)+SUM(cri_r7_f1)+SUM(cri_r8_f1)+SUM(cri_r9_f1)+SUM(cri_r10_f1)+SUM(cri_r11_f1)+SUM(cri_r12_f1)+SUM(cri_r13_f1)+SUM(cri_r14_f1)+SUM(cri_r15_f1)+SUM(cri_r16_f1)+SUM(cri_r17_f1)+SUM(cri_r18_f1)+SUM(cri_r19_f1)+SUM(cri_r20_f1)+SUM(cri_r21_f1)+SUM(cri_r22_f1)+SUM(cri_r23_f1)+SUM(cri_r24_f1) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO firstdose_given;
		EXECUTE 'SELECT SUM(cri_r1_f16)+SUM(cri_r2_f16)+SUM(cri_r3_f16)+SUM(cri_r4_f16)+SUM(cri_r5_f16)+SUM(cri_r6_f16)+SUM(cri_r7_f16)+SUM(cri_r8_f16)+SUM(cri_r9_f16)+SUM(cri_r10_f16)+SUM(cri_r11_f16)+SUM(cri_r12_f16)+SUM(cri_r13_f16)+SUM(cri_r14_f16)+SUM(cri_r15_f16)+SUM(cri_r16_f16)+SUM(cri_r17_f16)+SUM(cri_r18_f16)+SUM(cri_r19_f16)+SUM(cri_r20_f16)+SUM(cri_r21_f16)+SUM(cri_r22_f16)+SUM(cri_r23_f16)+SUM(cri_r24_f16) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO seconddose_given;
	    ELSIF dropout_type = 'ipv1-ipv2' THEN
		EXECUTE 'SELECT SUM(cri_r1_f13)+SUM(cri_r2_f13)+SUM(cri_r3_f13)+SUM(cri_r4_f13)+SUM(cri_r5_f13)+SUM(cri_r6_f13)+SUM(cri_r7_f13)+SUM(cri_r8_f13)+SUM(cri_r9_f1)+SUM(cri_r10_f13)+SUM(cri_r11_f13)+SUM(cri_r12_f13)+SUM(cri_r13_f13)+SUM(cri_r14_f13)+SUM(cri_r15_f13)+SUM(cri_r16_f13)+SUM(cri_r17_f13)+SUM(cri_r18_f13)+SUM(cri_r19_f13)+SUM(cri_r20_f13)+SUM(cri_r21_f13)+SUM(cri_r22_f13)+SUM(cri_r23_f13)+SUM(cri_r24_f13) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO firstdose_given;
		EXECUTE 'SELECT SUM(cri_r1_f21)+SUM(cri_r2_f21)+SUM(cri_r3_f21)+SUM(cri_r4_f21)+SUM(cri_r5_f21)+SUM(cri_r6_f21)+SUM(cri_r7_f21)+SUM(cri_r8_f21)+SUM(cri_r9_f21)+SUM(cri_r10_f21)+SUM(cri_r11_f21)+SUM(cri_r12_f21)+SUM(cri_r13_f21)+SUM(cri_r14_f21)+SUM(cri_r15_f21)+SUM(cri_r16_f21)+SUM(cri_r17_f21)+SUM(cri_r18_f21)+SUM(cri_r19_f21)+SUM(cri_r20_f21)+SUM(cri_r21_f21)+SUM(cri_r22_f21)+SUM(cri_r23_f21)+SUM(cri_r24_f21) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO seconddose_given;
            ELSE
                RETURN 0;
            END IF;
            
            rate := ((firstdose_given-seconddose_given)*100)::double precision/NULLIF(firstdose_given,0)::double precision;
            IF rate < 0 THEN
                rate = 0;
            END IF;
            RETURN rate;
       END;$$;


ALTER FUNCTION public.monthly_dropout_rate(ffmonth character varying, code character varying, dropout_type text) OWNER TO postgres;

--
-- Name: monthly_dropout_rate(character varying, character varying, text, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION monthly_dropout_rate(monthfrom character varying, code character varying, dropout_type text, monthto character varying) RETURNS double precision
    LANGUAGE plpgsql
    AS $$DECLARE
   rate double precision;
   whereText text;
   firstdose_given integer;
   seconddose_given integer;

       BEGIN
            IF character_length(code) = '1' THEN
                whereText := 'procode';
            ELSIF character_length(code) = '3' THEN
                whereText := 'distcode';
            ELSIF character_length(code) = '6' THEN
                whereText := 'facode';
            ELSIF character_length(code) = '9' THEN
                whereText := 'uncode';
            ELSE
                return 0;
            END IF;
            
            IF dropout_type = 'penta1-measles1' THEN
                EXECUTE 'SELECT SUM(cri_r1_f7)+SUM(cri_r2_f7)+SUM(cri_r3_f7)+SUM(cri_r4_f7)+SUM(cri_r5_f7)+SUM(cri_r6_f7)+SUM(cri_r7_f7)+SUM(cri_r8_f7)+SUM(cri_r9_f7)+SUM(cri_r10_f7)+SUM(cri_r11_f7)+SUM(cri_r12_f7)+SUM(cri_r13_f7)+SUM(cri_r14_f7)+SUM(cri_r15_f7)+SUM(cri_r16_f7)+SUM(cri_r17_f7)+SUM(cri_r18_f7)+SUM(cri_r19_f7)+SUM(cri_r20_f7)+SUM(cri_r21_f7)+SUM(cri_r22_f7)+SUM(cri_r23_f7)+SUM(cri_r24_f7) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' AND fmonth BETWEEN '''||monthfrom||''' AND '''||monthto||''' ' INTO firstdose_given;
                EXECUTE 'SELECT SUM(cri_r1_f16)+SUM(cri_r2_f16)+SUM(cri_r3_f16)+SUM(cri_r4_f16)+SUM(cri_r5_f16)+SUM(cri_r6_f16)+SUM(cri_r7_f16)+SUM(cri_r8_f16)+SUM(cri_r9_f16)+SUM(cri_r10_f16)+SUM(cri_r11_f16)+SUM(cri_r12_f16)+SUM(cri_r13_f16)+SUM(cri_r14_f16)+SUM(cri_r15_f16)+SUM(cri_r16_f16)+SUM(cri_r17_f16)+SUM(cri_r18_f16)+SUM(cri_r19_f16)+SUM(cri_r20_f16)+SUM(cri_r21_f16)+SUM(cri_r22_f16)+SUM(cri_r23_f16)+SUM(cri_r24_f16) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' AND fmonth BETWEEN '''||monthfrom||''' AND '''||monthto||''' ' INTO seconddose_given;
            ELSIF dropout_type = 'penta1-penta3' THEN
                EXECUTE 'SELECT SUM(cri_r1_f7)+SUM(cri_r2_f7)+SUM(cri_r3_f7)+SUM(cri_r4_f7)+SUM(cri_r5_f7)+SUM(cri_r6_f7)+SUM(cri_r7_f7)+SUM(cri_r8_f7)+SUM(cri_r9_f7)+SUM(cri_r10_f7)+SUM(cri_r11_f7)+SUM(cri_r12_f7)+SUM(cri_r13_f7)+SUM(cri_r14_f7)+SUM(cri_r15_f7)+SUM(cri_r16_f7)+SUM(cri_r17_f7)+SUM(cri_r18_f7)+SUM(cri_r19_f7)+SUM(cri_r20_f7)+SUM(cri_r21_f7)+SUM(cri_r22_f7)+SUM(cri_r23_f7)+SUM(cri_r24_f7) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' AND fmonth BETWEEN '''||monthfrom||''' AND '''||monthto||''' ' INTO firstdose_given;
                EXECUTE 'SELECT SUM(cri_r1_f9)+SUM(cri_r2_f9)+SUM(cri_r3_f9)+SUM(cri_r4_f9)+SUM(cri_r5_f9)+SUM(cri_r6_f9)+SUM(cri_r7_f9)+SUM(cri_r8_f9)+SUM(cri_r9_f9)+SUM(cri_r10_f9)+SUM(cri_r11_f9)+SUM(cri_r12_f9)+SUM(cri_r13_f9)+SUM(cri_r14_f9)+SUM(cri_r15_f9)+SUM(cri_r16_f9)+SUM(cri_r17_f9)+SUM(cri_r18_f9)+SUM(cri_r19_f9)+SUM(cri_r20_f9)+SUM(cri_r21_f9)+SUM(cri_r22_f9)+SUM(cri_r23_f9)+SUM(cri_r24_f9) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' AND fmonth BETWEEN '''||monthfrom||''' AND '''||monthto||''' ' INTO seconddose_given;
            ELSIF dropout_type = 'measles1-measles2' THEN
                EXECUTE 'SELECT SUM(cri_r1_f16)+SUM(cri_r2_f16)+SUM(cri_r3_f16)+SUM(cri_r4_f16)+SUM(cri_r5_f16)+SUM(cri_r6_f16)+SUM(cri_r7_f16)+SUM(cri_r8_f16)+SUM(cri_r9_f16)+SUM(cri_r10_f16)+SUM(cri_r11_f16)+SUM(cri_r12_f16)+SUM(cri_r13_f16)+SUM(cri_r14_f16)+SUM(cri_r15_f16)+SUM(cri_r16_f16)+SUM(cri_r17_f16)+SUM(cri_r18_f16)+SUM(cri_r19_f16)+SUM(cri_r20_f16)+SUM(cri_r21_f16)+SUM(cri_r22_f16)+SUM(cri_r23_f16)+SUM(cri_r24_f16) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' AND fmonth BETWEEN '''||monthfrom||''' AND '''||monthto||''' ' INTO firstdose_given;
                EXECUTE 'SELECT SUM(cri_r1_f18)+SUM(cri_r2_f18)+SUM(cri_r3_f18)+SUM(cri_r4_f18)+SUM(cri_r5_f18)+SUM(cri_r6_f18)+SUM(cri_r7_f18)+SUM(cri_r8_f18)+SUM(cri_r9_f18)+SUM(cri_r10_f18)+SUM(cri_r11_f18)+SUM(cri_r12_f18)+SUM(cri_r13_f18)+SUM(cri_r14_f18)+SUM(cri_r15_f18)+SUM(cri_r16_f18)+SUM(cri_r17_f18)+SUM(cri_r18_f18)+SUM(cri_r19_f18)+SUM(cri_r20_f18)+SUM(cri_r21_f18)+SUM(cri_r22_f18)+SUM(cri_r23_f18)+SUM(cri_r24_f18) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' AND fmonth BETWEEN '''||monthfrom||''' AND '''||monthto||''' ' INTO seconddose_given;
            ELSIF dropout_type = 'tt1-tt2' THEN
                EXECUTE 'SELECT SUM(ttri_r1_f1)+SUM(ttri_r2_f1)+SUM(ttri_r3_f1)+SUM(ttri_r4_f1)+SUM(ttri_r5_f1)+SUM(ttri_r6_f1)+SUM(ttri_r7_f1)+SUM(ttri_r8_f1) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' AND fmonth BETWEEN '''||monthfrom||''' AND '''||monthto||''' ' INTO firstdose_given;
                EXECUTE 'SELECT SUM(ttri_r1_f2)+SUM(ttri_r2_f2)+SUM(ttri_r3_f2)+SUM(ttri_r4_f2)+SUM(ttri_r5_f2)+SUM(ttri_r6_f2)+SUM(ttri_r7_f2)+SUM(ttri_r8_f2) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' AND fmonth BETWEEN '''||monthfrom||''' AND '''||monthto||''' ' INTO seconddose_given;
            ELSIF dropout_type = 'tt1-tt3' THEN
                EXECUTE 'SELECT SUM(ttri_r1_f1)+SUM(ttri_r2_f1)+SUM(ttri_r3_f1)+SUM(ttri_r4_f1)+SUM(ttri_r5_f1)+SUM(ttri_r6_f1)+SUM(ttri_r7_f1)+SUM(ttri_r8_f1)+SUM(ttoui_r1_f1)+SUM(ttoui_r2_f1)+SUM(ttoui_r3_f1)+SUM(ttoui_r4_f1)+SUM(ttoui_r5_f1)+SUM(ttoui_r6_f1)+SUM(ttoui_r7_f1)+SUM(ttoui_r8_f1) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' AND fmonth BETWEEN '''||monthfrom||''' AND '''||monthto||''' ' INTO firstdose_given;
                EXECUTE 'SELECT SUM(ttri_r1_f3)+SUM(ttri_r2_f3)+SUM(ttri_r3_f3)+SUM(ttri_r4_f3)+SUM(ttri_r5_f3)+SUM(ttri_r6_f3)+SUM(ttri_r7_f3)+SUM(ttri_r8_f3)+SUM(ttoui_r1_f3)+SUM(ttoui_r2_f3)+SUM(ttoui_r3_f3)+SUM(ttoui_r4_f3)+SUM(ttoui_r5_f3)+SUM(ttoui_r6_f3)+SUM(ttoui_r7_f3)+SUM(ttoui_r8_f3) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' AND fmonth BETWEEN '''||monthfrom||''' AND '''||monthto||''' ' INTO seconddose_given;
            ELSIF dropout_type = 'rota1-rota2' THEN
		EXECUTE 'SELECT SUM(cri_r1_f14)+SUM(cri_r2_f14)+SUM(cri_r3_f14)+SUM(cri_r4_f14)+SUM(cri_r5_f14)+SUM(cri_r6_f14)+SUM(cri_r7_f14)+SUM(cri_r8_f14)+SUM(cri_r9_f14)+SUM(cri_r10_f14)+SUM(cri_r11_f14)+SUM(cri_r12_f14)+SUM(cri_r13_f14)+SUM(cri_r14_f14)+SUM(cri_r15_f14)+SUM(cri_r16_f14)+SUM(cri_r17_f14)+SUM(cri_r18_f14)+SUM(cri_r19_f14)+SUM(cri_r20_f14)+SUM(cri_r21_f14)+SUM(cri_r22_f14)+SUM(cri_r23_f14)+SUM(cri_r24_f14) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' AND fmonth BETWEEN '''||monthfrom||''' AND '''||monthto||''' ' INTO firstdose_given;
		EXECUTE 'SELECT SUM(cri_r1_f15)+SUM(cri_r2_f15)+SUM(cri_r3_f15)+SUM(cri_r4_f15)+SUM(cri_r5_f15)+SUM(cri_r6_f15)+SUM(cri_r7_f15)+SUM(cri_r8_f15)+SUM(cri_r9_f15)+SUM(cri_r10_f15)+SUM(cri_r11_f15)+SUM(cri_r12_f15)+SUM(cri_r13_f15)+SUM(cri_r14_f15)+SUM(cri_r15_f15)+SUM(cri_r16_f15)+SUM(cri_r17_f15)+SUM(cri_r18_f15)+SUM(cri_r19_f15)+SUM(cri_r20_f15)+SUM(cri_r21_f15)+SUM(cri_r22_f15)+SUM(cri_r23_f15)+SUM(cri_r24_f15) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' AND fmonth BETWEEN '''||monthfrom||''' AND '''||monthto||''' ' INTO seconddose_given;
            ELSIF dropout_type = 'bcg-measles1' THEN
		EXECUTE 'SELECT SUM(cri_r1_f1)+SUM(cri_r2_f1)+SUM(cri_r3_f1)+SUM(cri_r4_f1)+SUM(cri_r5_f1)+SUM(cri_r6_f1)+SUM(cri_r7_f1)+SUM(cri_r8_f1)+SUM(cri_r9_f1)+SUM(cri_r10_f1)+SUM(cri_r11_f1)+SUM(cri_r12_f1)+SUM(cri_r13_f1)+SUM(cri_r14_f1)+SUM(cri_r15_f1)+SUM(cri_r16_f1)+SUM(cri_r17_f1)+SUM(cri_r18_f1)+SUM(cri_r19_f1)+SUM(cri_r20_f1)+SUM(cri_r21_f1)+SUM(cri_r22_f1)+SUM(cri_r23_f1)+SUM(cri_r24_f1) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO firstdose_given;
		EXECUTE 'SELECT SUM(cri_r1_f16)+SUM(cri_r2_f16)+SUM(cri_r3_f16)+SUM(cri_r4_f16)+SUM(cri_r5_f16)+SUM(cri_r6_f16)+SUM(cri_r7_f16)+SUM(cri_r8_f16)+SUM(cri_r9_f16)+SUM(cri_r10_f16)+SUM(cri_r11_f16)+SUM(cri_r12_f16)+SUM(cri_r13_f16)+SUM(cri_r14_f16)+SUM(cri_r15_f16)+SUM(cri_r16_f16)+SUM(cri_r17_f16)+SUM(cri_r18_f16)+SUM(cri_r19_f16)+SUM(cri_r20_f16)+SUM(cri_r21_f16)+SUM(cri_r22_f16)+SUM(cri_r23_f16)+SUM(cri_r24_f16) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO seconddose_given;
	    ELSIF dropout_type = 'ipv1-ipv2' THEN
		EXECUTE 'SELECT SUM(cri_r1_f13)+SUM(cri_r2_f13)+SUM(cri_r3_f13)+SUM(cri_r4_f13)+SUM(cri_r5_f13)+SUM(cri_r6_f13)+SUM(cri_r7_f13)+SUM(cri_r8_f13)+SUM(cri_r9_f1)+SUM(cri_r10_f13)+SUM(cri_r11_f13)+SUM(cri_r12_f13)+SUM(cri_r13_f13)+SUM(cri_r14_f13)+SUM(cri_r15_f13)+SUM(cri_r16_f13)+SUM(cri_r17_f13)+SUM(cri_r18_f13)+SUM(cri_r19_f13)+SUM(cri_r20_f13)+SUM(cri_r21_f13)+SUM(cri_r22_f13)+SUM(cri_r23_f13)+SUM(cri_r24_f13) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO firstdose_given;
		EXECUTE 'SELECT SUM(cri_r1_f21)+SUM(cri_r2_f21)+SUM(cri_r3_f21)+SUM(cri_r4_f21)+SUM(cri_r5_f21)+SUM(cri_r6_f21)+SUM(cri_r7_f21)+SUM(cri_r8_f21)+SUM(cri_r9_f21)+SUM(cri_r10_f21)+SUM(cri_r11_f21)+SUM(cri_r12_f21)+SUM(cri_r13_f21)+SUM(cri_r14_f21)+SUM(cri_r15_f21)+SUM(cri_r16_f21)+SUM(cri_r17_f21)+SUM(cri_r18_f21)+SUM(cri_r19_f21)+SUM(cri_r20_f21)+SUM(cri_r21_f21)+SUM(cri_r22_f21)+SUM(cri_r23_f21)+SUM(cri_r24_f21) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO seconddose_given;
            ELSE
                RETURN 0;
            END IF;
            
            rate := ((firstdose_given-seconddose_given)*100)::double precision/NULLIF(firstdose_given,0)::double precision;
            IF rate < 0 THEN
                rate = 0;
            END IF;
            RETURN rate;
       END;$$;


ALTER FUNCTION public.monthly_dropout_rate(monthfrom character varying, code character varying, dropout_type text, monthto character varying) OWNER TO postgres;

--
-- Name: noncclocationname(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION noncclocationname(locid integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
     locname text;
   BEGIN
    SELECT location_name into locname from epi_non_ccm_locations where pk_id=locid;
   RETURN locname;
   END$$;


ALTER FUNCTION public.noncclocationname(locid integer) OWNER TO postgres;

--
-- Name: openvial_wastagerate(character varying, character varying, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION openvial_wastagerate(ffmonth character varying, code character varying, consumption_id integer, vaccineid integer) RETURNS double precision
    LANGUAGE plpgsql
    AS $_$DECLARE
   rate double precision;
   whereText text;
   childrenVaccinated integer;
   vaccinationid integer;
   dosesused integer;
   monthpart integer;
   yearpart integer;
       BEGIN            
             IF vaccineid= 4 THEN
               vaccinationid := 7;
            ELSIF vaccineid= 5 THEN
               vaccinationid := 10;
            ELSIF vaccineid= 6 THEN
               vaccinationid := 16;
            ELSIF vaccineid= 10 THEN
               vaccinationid := 2;
            ELSIF vaccineid= 11 THEN
               vaccinationid := 13;
            ELSIF vaccineid= 18 THEN
               vaccinationid := 14;
            ELSE
               vaccinationid := vaccineID;
            END IF;

            IF character_length(code) = '1' THEN
               whereText := 'procode';
            ELSIF character_length(code) = '3' THEN
               whereText := 'distcode';
            ELSIF character_length(code) = '6' THEN
               whereText := 'facode';
            ELSIF character_length(code) = '9' THEN
               whereText := 'uncode';
            ELSE
               return 0;
            END IF;
            
              EXECUTE ' SELECT round(coalesce(round(((sum(used_doses)-sum(vaccinated))::numeric/NULLIF(sum(used_doses)::numeric, 0))*100, 1),0)::numeric,0) FROM epi_consumption_master  master left join epi_consumption_detail detail on master.pk_id=detail.main_id   WHERE '||whereText||'='''||code||'''  and item_id='||$3||' and fmonth ='''||ffmonth||''' ' INTO rate;           
         
            yearpart := split_part(ffmonth,'-',1);
            monthpart := split_part(ffmonth,'-',2);
            IF monthpart = 1 THEN
               monthpart := 12;
               yearpart := yearpart-1;
            ELSE
               monthpart := monthpart-1;
            END IF;
            
            -- ffmonth := yearpart||'-'||LTRIM(to_char(monthpart,'09'),' ');
            --childrenVaccinated := getmonthlyvaccination(ffmonth,code,vaccinationid);
            --rate := (((dosesused) - childrenVaccinated)*100)::double precision/NULLIF((dosesused),0)::double precision;
            IF rate < 0 THEN
               rate := 0;
            END IF;
            
            RETURN rate;
       END;$_$;


ALTER FUNCTION public.openvial_wastagerate(ffmonth character varying, code character varying, consumption_id integer, vaccineid integer) OWNER TO postgres;

--
-- Name: FUNCTION openvial_wastagerate(ffmonth character varying, code character varying, consumption_id integer, vaccineid integer); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION openvial_wastagerate(ffmonth character varying, code character varying, consumption_id integer, vaccineid integer) IS 'according to new consumption table ';


--
-- Name: other_case_reported(character varying, character varying, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION other_case_reported(fweekk character varying, facodee character varying, case_type text) RETURNS character varying
    LANGUAGE plpgsql
    AS $$DECLARE
        totpop  character varying;
    BEGIN
       EXECUTE 'SELECT CASE(select EXISTS(select count(case_reported) from case_investigation_db where fweek = ''' || fweekk || ''' and facode = ''' || facodee|| '''  and case_type= ''' || case_type|| ''' HAVING count(case_reported) > 0 ) )  
        WHEN TRUE 
              THEN (select CASE(count(case_reported)) 
                        WHEN 1
                             THEN 
                                 (select CASE(case_reported)
                                       WHEN 1
                                             THEN ''1''
                                       WHEN 0
                                             THEN ''zr''
                                       END
                                 from weekly_vpd where fweek = ''' || fweekk || ''' and facode = ''' || facodee|| ''' and case_type= ''' || case_type|| ''')
                             ELSE 
                                 count(case_reported)::TEXT 
                        END 
                    from case_investigation_db where fweek = ''' || fweekk || ''' and facode = ''' || facodee|| ''' and case_type= ''' || case_type|| ''')     
              ELSE ''0'' END' into totpop;
    RETURN totpop;
    END;
$$;


ALTER FUNCTION public.other_case_reported(fweekk character varying, facodee character varying, case_type text) OWNER TO postgres;

--
-- Name: parentassettype(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION parentassettype(subtypeid integer) RETURNS text
    LANGUAGE plpgsql
    AS $$ DECLARE
     asname text;
   BEGIN
    SELECT assetname(parent_id) into asname from epi_cc_asset_types where pk_id=subtypeid;
   RETURN asname;
   END$$;


ALTER FUNCTION public.parentassettype(subtypeid integer) OWNER TO postgres;

--
-- Name: province_population_calculation(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION province_population_calculation() RETURNS trigger
    LANGUAGE plpgsql
    AS $$BEGIN

DELETE FROM province_population;

INSERT INTO province_population (procode,population,year,created_date) select 3 as procode,sum(population) as population,year,now() as created_date from districts_population group by year order by year;

RETURN NEW;

END;$$;


ALTER FUNCTION public.province_population_calculation() OWNER TO postgres;

--
-- Name: provincename(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION provincename(pcode text) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
        pname text;
    BEGIN
	SELECT province into pname from provinces where procode=pcode;
        RETURN pname;
    END;$$;


ALTER FUNCTION public.provincename(pcode text) OWNER TO postgres;

--
-- Name: purposename(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION purposename(ppcode integer) RETURNS text
    LANGUAGE plpgsql
    AS $$ DECLARE
     ppname text;
   BEGIN
    SELECT type into ppname from campaign_purpose where id=ppcode;
   RETURN ppname;
   END$$;


ALTER FUNCTION public.purposename(ppcode integer) OWNER TO postgres;

--
-- Name: sessions_dropout_rate(character varying, character varying, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION sessions_dropout_rate(ffmonth character varying, code character varying, session_type text) RETURNS double precision
    LANGUAGE plpgsql
    AS $$DECLARE
   perc double precision;
   whereText text;
   sessions_planned integer;
   sessions_held integer;

   BEGIN
        IF character_length(code) = '1' THEN
           whereText := 'procode';
        ELSIF character_length(code) = '3' THEN
           whereText := 'distcode';
        ELSIF character_length(code) = '6' THEN
           whereText := 'facode';
        ELSIF character_length(code) = '9' THEN
           whereText := 'uncode';
        ELSE
           return 0;
        END IF;

        EXECUTE 'SELECT SUM('||session_type||'_vacc_planned) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO sessions_planned;
        EXECUTE 'SELECT SUM('||session_type||'_vacc_held) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO sessions_held;

        perc := ((sessions_planned-sessions_held)*100)::double precision/NULLIF(sessions_planned,0)::double precision;
        IF perc < 0 THEN
           perc := 0;
        END IF;

        RETURN COALESCE(perc,0);
    END;$$;


ALTER FUNCTION public.sessions_dropout_rate(ffmonth character varying, code character varying, session_type text) OWNER TO postgres;

--
-- Name: sessions_planned_conducted(character varying, character varying, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION sessions_planned_conducted(ffmonth character varying, code character varying, session_type text) RETURNS double precision
    LANGUAGE plpgsql
    AS $$DECLARE
   perc double precision;
   whereText text;
   sessions_planned integer;
   sessions_held integer;

   BEGIN
        IF character_length(code) = '1' THEN
           whereText := 'procode';
        ELSIF character_length(code) = '3' THEN
           whereText := 'distcode';
        ELSIF character_length(code) = '6' THEN
           whereText := 'facode';
        ELSIF character_length(code) = '9' THEN
           whereText := 'uncode';
        ELSE
           return 0;
        END IF;

        EXECUTE 'SELECT SUM('||session_type||'_vacc_planned) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO sessions_planned;
        EXECUTE 'SELECT SUM('||session_type||'_vacc_held) FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' and fmonth = '''||ffmonth||''' ' INTO sessions_held;

        perc := (sessions_held*100)::double precision/NULLIF(sessions_planned,0)::double precision;
        RETURN COALESCE(perc,0);
    END;$$;


ALTER FUNCTION public.sessions_planned_conducted(ffmonth character varying, code character varying, session_type text) OWNER TO postgres;

--
-- Name: signs_symptoms(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION signs_symptoms(id integer) RETURNS text
    LANGUAGE plpgsql
    AS $$ DECLARE
        dname text;
    BEGIN
	SELECT 
           CASE bs_cry 
                 WHEN 'Yes' THEN 'Cry and suck during first 2 days'
                 ELSE ' ' END 
          || CASE bs_stiffness 
                 WHEN 'Yes' THEN ' Stiffness'
                 ELSE ' ' END 
          || CASE bs_spasms 
                 WHEN 'Yes' THEN ' Spasms or convulsions'
                 ELSE ' ' END 
          || CASE bs_stop_sucking 
                 WHEN 'Yes' THEN ' Stopped sucking after 2 days'
                 ELSE ' ' END 
          INTO dname 
        FROM nnt_investigation_form where id=id;
      
      RETURN dname;
    END;$$;


ALTER FUNCTION public.signs_symptoms(id integer) OWNER TO postgres;

--
-- Name: stackholdername(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION stackholdername(stackhldrid integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
     stckname text;
   BEGIN
    SELECT stakeholder_name into stckname from epi_stakeholders where pk_id=stackhldrid;
   RETURN stckname;
   END$$;


ALTER FUNCTION public.stackholdername(stackhldrid integer) OWNER TO postgres;

--
-- Name: sumvaccinevacination(integer, text, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION sumvaccinevacination(vaccineid integer, code text, monthfrom character varying, monthto character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
   columns text;
   outuc_columns text;
   vaccinesum integer;
   whereText text;
       BEGIN
            IF character_length(code) = '1' THEN
               whereText := 'procode';
               outuc_columns= '+oui_r1_f'||vaccineid||'+oui_r2_f'||vaccineid||'+oui_r3_f'||vaccineid||'+oui_r4_f'||vaccineid||'+oui_r5_f'||vaccineid||'+oui_r6_f'||vaccineid||'+oui_r7_f'||vaccineid||'+oui_r8_f'||vaccineid||'+oui_r9_f'||vaccineid||'+oui_r10_f'||vaccineid||'+oui_r11_f'||vaccineid||'+oui_r12_f'||vaccineid||'+oui_r13_f'||vaccineid||'+oui_r14_f'||vaccineid||'+oui_r15_f'||vaccineid||'+oui_r16_f'||vaccineid||'+oui_r17_f'||vaccineid||'+oui_r18_f'||vaccineid||'+oui_r19_f'||vaccineid||'+oui_r20_f'||vaccineid||'+oui_r21_f'||vaccineid||'+oui_r22_f'||vaccineid||'+oui_r23_f'||vaccineid||'+oui_r24_f'||vaccineid;
            END IF;
            IF character_length(code) = '3' THEN
               whereText := 'distcode';
               outuc_columns= '+oui_r1_f'||vaccineid||'+oui_r2_f'||vaccineid||'+oui_r3_f'||vaccineid||'+oui_r4_f'||vaccineid||'+oui_r5_f'||vaccineid||'+oui_r6_f'||vaccineid||'+oui_r7_f'||vaccineid||'+oui_r8_f'||vaccineid||'+oui_r9_f'||vaccineid||'+oui_r10_f'||vaccineid||'+oui_r11_f'||vaccineid||'+oui_r12_f'||vaccineid||'+oui_r13_f'||vaccineid||'+oui_r14_f'||vaccineid||'+oui_r15_f'||vaccineid||'+oui_r16_f'||vaccineid||'+oui_r17_f'||vaccineid||'+oui_r18_f'||vaccineid||'+oui_r19_f'||vaccineid||'+oui_r20_f'||vaccineid||'+oui_r21_f'||vaccineid||'+oui_r22_f'||vaccineid||'+oui_r23_f'||vaccineid||'+oui_r24_f'||vaccineid;
            END IF;
            IF character_length(code) = '9' THEN
               whereText := 'uncode';
               outuc_columns='';
            END IF;
            IF character_length(code) = '6' THEN
               whereText := 'facode';
               outuc_columns='';
            END IF; 
            
            columns= 'cri_r1_f'||vaccineid||'+cri_r2_f'||vaccineid||'+cri_r3_f'||vaccineid||'+cri_r4_f'||vaccineid||'+cri_r5_f'||vaccineid||'+cri_r6_f'||vaccineid||'+cri_r7_f'||vaccineid||'+cri_r8_f'||vaccineid||'+cri_r9_f'||vaccineid||'+cri_r10_f'||vaccineid||'+cri_r11_f'||vaccineid||'+cri_r12_f'||vaccineid||'+cri_r13_f'||vaccineid||'+cri_r14_f'||vaccineid||'+cri_r15_f'||vaccineid||'+cri_r16_f'||vaccineid||'+cri_r17_f'||vaccineid||'+cri_r18_f'||vaccineid||'+cri_r19_f'||vaccineid||'+cri_r20_f'||vaccineid||'+cri_r21_f'||vaccineid||'+cri_r22_f'||vaccineid||'+cri_r23_f'||vaccineid||'+cri_r24_f'||vaccineid||outuc_columns;
            EXECUTE 'SELECT SUM('||columns||') FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' AND fmonth BETWEEN '''||monthfrom||''' AND '''||monthto||''' ' INTO  vaccinesum;
            RETURN vaccinesum;
       END;$$;


ALTER FUNCTION public.sumvaccinevacination(vaccineid integer, code text, monthfrom character varying, monthto character varying) OWNER TO postgres;

--
-- Name: sumvaccinevacination_female(integer, text, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION sumvaccinevacination_female(vaccineid integer, code text, monthfrom character varying, monthto character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
   columns text;
   outuc_columns text;
   vaccinesum integer;
   whereText text;
       BEGIN
            IF character_length(code) = '1' THEN
               whereText := 'procode';
               outuc_columns= '+oui_r2_f'||vaccineid||'+oui_r4_f'||vaccineid||'+oui_r6_f'||vaccineid||'+oui_r8_f'||vaccineid||'+oui_r10_f'||vaccineid||'+oui_r12_f'||vaccineid||'+oui_r14_f'||vaccineid||'+oui_r16_f'||vaccineid||'+oui_r18_f'||vaccineid||'+oui_r20_f'||vaccineid||'+oui_r22_f'||vaccineid||'+oui_r24_f'||vaccineid;
            END IF;
            IF character_length(code) = '3' THEN
               whereText := 'distcode';
               outuc_columns= '+oui_r2_f'||vaccineid||'+oui_r4_f'||vaccineid||'+oui_r6_f'||vaccineid||'+oui_r8_f'||vaccineid||'+oui_r10_f'||vaccineid||'+oui_r12_f'||vaccineid||'+oui_r14_f'||vaccineid||'+oui_r16_f'||vaccineid||'+oui_r18_f'||vaccineid||'+oui_r20_f'||vaccineid||'+oui_r22_f'||vaccineid||'+oui_r24_f'||vaccineid;
            END IF;
            IF character_length(code) = '9' THEN
               whereText := 'uncode';
               outuc_columns='';
            END IF;
            IF character_length(code) = '6' THEN
               whereText := 'facode';
               outuc_columns='';
            END IF; 
            
            columns= 'cri_r2_f'||vaccineid||'+cri_r4_f'||vaccineid||'+cri_r6_f'||vaccineid||'+cri_r8_f'||vaccineid||'+cri_r10_f'||vaccineid||'+cri_r12_f'||vaccineid||'+cri_r14_f'||vaccineid||'+cri_r16_f'||vaccineid||'+cri_r18_f'||vaccineid||'+cri_r20_f'||vaccineid||'+cri_r22_f'||vaccineid||'+cri_r24_f'||vaccineid||outuc_columns;
            EXECUTE 'SELECT SUM('||columns||') FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' AND fmonth BETWEEN '''||monthfrom||''' AND '''||monthto||''' ' INTO  vaccinesum;
            RETURN vaccinesum;
       END;$$;


ALTER FUNCTION public.sumvaccinevacination_female(vaccineid integer, code text, monthfrom character varying, monthto character varying) OWNER TO postgres;

--
-- Name: sumvaccinevacination_male(integer, text, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION sumvaccinevacination_male(vaccineid integer, code text, monthfrom character varying, monthto character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
   columns text;
   outuc_columns text;
   vaccinesum integer;
   whereText text;
       BEGIN
            IF character_length(code) = '1' THEN
               whereText := 'procode';
               outuc_columns= '+oui_r1_f'||vaccineid||'+oui_r3_f'||vaccineid||'+oui_r5_f'||vaccineid||'+oui_r7_f'||vaccineid||'+oui_r9_f'||vaccineid||'+oui_r11_f'||vaccineid||'+oui_r13_f'||vaccineid||'+oui_r15_f'||vaccineid||'+oui_r17_f'||vaccineid||'+oui_r19_f'||vaccineid||'+oui_r21_f'||vaccineid||'+oui_r23_f'||vaccineid;
            END IF;
            IF character_length(code) = '3' THEN
               whereText := 'distcode';
               outuc_columns= '+oui_r1_f'||vaccineid||'+oui_r3_f'||vaccineid||'+oui_r5_f'||vaccineid||'+oui_r7_f'||vaccineid||'+oui_r9_f'||vaccineid||'+oui_r11_f'||vaccineid||'+oui_r13_f'||vaccineid||'+oui_r15_f'||vaccineid||'+oui_r17_f'||vaccineid||'+oui_r19_f'||vaccineid||'+oui_r21_f'||vaccineid||'+oui_r23_f'||vaccineid;
            END IF;
            IF character_length(code) = '9' THEN
               whereText := 'uncode';
               outuc_columns='';
            END IF;
            IF character_length(code) = '6' THEN
               whereText := 'facode';
               outuc_columns='';
            END IF; 
            
            columns=
'cri_r1_f'||vaccineid||'+cri_r3_f'||vaccineid||'+cri_r5_f'||vaccineid||'+cri_r7_f'||vaccineid||'+cri_r9_f'||vaccineid||'+cri_r11_f'||vaccineid||'+cri_r13_f'||vaccineid||'+cri_r15_f'||vaccineid||'+cri_r17_f'||vaccineid||'+cri_r19_f'||vaccineid||'+cri_r21_f'||vaccineid||'+cri_r23_f'||vaccineid||outuc_columns;
            EXECUTE 'SELECT SUM('||columns||') FROM fac_mvrf_db WHERE '||whereText||'='''||code||''' AND fmonth BETWEEN '''||monthfrom||''' AND '''||monthto||''' ' INTO  vaccinesum;
            RETURN vaccinesum;
       END;$$;


ALTER FUNCTION public.sumvaccinevacination_male(vaccineid integer, code text, monthfrom character varying, monthto character varying) OWNER TO postgres;

--
-- Name: supervisorname(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION supervisorname(scode text) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
        sname text;
    BEGIN
	SELECT supervisorname into sname from supervisordb where supervisorcode=scode;
        RETURN sname;
    END;
  $$;


ALTER FUNCTION public.supervisorname(scode text) OWNER TO postgres;

--
-- Name: tech_pop(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION tech_pop(techcode text) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
        tech_pop integer;
    BEGIN
	SELECT population into tech_pop from techniciandb_pop where techniciancode=techcode;
        RETURN tech_pop;
    END;$$;


ALTER FUNCTION public.tech_pop(techcode text) OWNER TO postgres;

--
-- Name: technicianname(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION technicianname(techcode text) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $$DECLARE
        techname text;
    BEGIN
	SELECT technicianname into techname from techniciandb where techniciancode=techcode;
        RETURN techname ;
    END;$$;


ALTER FUNCTION public.technicianname(techcode text) OWNER TO postgres;

--
-- Name: tehsilname(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION tehsilname(thcode text) RETURNS text
    LANGUAGE plpgsql
    AS $$
  DECLARE
        tname text;
    BEGIN
	SELECT tehsil into tname from tehsil where tcode=thcode;
        RETURN tname;
    END;
  $$;


ALTER FUNCTION public.tehsilname(thcode text) OWNER TO postgres;

--
-- Name: trimandappend(text, integer, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION trimandappend(str text, allowedchar integer, appendstr text) RETURNS text
    LANGUAGE plpgsql
    AS $_$DECLARE
     outstr text;
   BEGIN
SELECT case when length($1)>=$2 then substr($1,0,$2) || $3 else $1 end into outstr;
RETURN outstr;
   END$_$;


ALTER FUNCTION public.trimandappend(str text, allowedchar integer, appendstr text) OWNER TO postgres;

--
-- Name: unitname(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION unitname(itempacksizeid integer) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
        unitname text;
    BEGIN
	SELECT item_unit_name into unitname from epi_item_units join epi_item_pack_sizes on epi_item_units.pk_id=epi_item_pack_sizes.item_unit_id where epi_item_pack_sizes.pk_id = itempacksizeid;
        RETURN unitname;
    END;$$;


ALTER FUNCTION public.unitname(itempacksizeid integer) OWNER TO postgres;

--
-- Name: unname(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION unname(ucode text) RETURNS text
    LANGUAGE plpgsql
    AS $$
  DECLARE
        uname text;
    BEGIN
	SELECT un_name into uname from unioncouncil where uncode=ucode;
        RETURN uname;
    END;
  $$;


ALTER FUNCTION public.unname(ucode text) OWNER TO postgres;

--
-- Name: update_monthwise_district_due_reports_in_compliances(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION update_monthwise_district_due_reports_in_compliances() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
    rowexist boolean;
    duem1 integer;
    duem2 integer;
    duem3 integer;
    duem4 integer;
    duem5 integer;
    duem6 integer;
    duem7 integer;
    duem8 integer;
    duem9 integer;
    duem10 integer;
    duem11 integer;
    duem12 integer;
    pcode character varying(1);
    dcode character varying(3);
    preyear character varying(4);
    currentyear character varying(4);
	
BEGIN
    preyear:= '2016';
    currentyear := date_part('year', CURRENT_DATE);
    pcode := substring(OLD.facode from 1 for 1);
    dcode := substring(OLD.facode from 1 for 3);

FOR preyear IN preyear..currentyear LOOP
    duem1 := get_monthly_fstatus_vacc(preyear||'-01',dcode)::integer;
    duem2 := get_monthly_fstatus_vacc(preyear||'-02',dcode)::integer;
    duem3 := get_monthly_fstatus_vacc(preyear||'-03',dcode)::integer;
    duem4 := get_monthly_fstatus_vacc(preyear||'-04',dcode)::integer;
    duem5 := get_monthly_fstatus_vacc(preyear||'-05',dcode)::integer;
    duem6 := get_monthly_fstatus_vacc(preyear||'-06',dcode)::integer;
    duem7 := get_monthly_fstatus_vacc(preyear||'-07',dcode)::integer;
    duem8 := get_monthly_fstatus_vacc(preyear||'-08',dcode)::integer;
    duem9 := get_monthly_fstatus_vacc(preyear||'-09',dcode)::integer;
    duem10 := get_monthly_fstatus_vacc(preyear||'-10',dcode)::integer;
    duem11 := get_monthly_fstatus_vacc(preyear||'-11',dcode)::integer;
    duem12 := get_monthly_fstatus_vacc(preyear||'-12',dcode)::integer;

SELECT exists(SELECT * FROM consumptioncompliance WHERE year = preyear::text AND distcode = dcode AND procode = pcode) into rowexist;
	IF rowexist = FALSE THEN
		EXECUTE 'INSERT INTO consumptioncompliance (year, procode, distcode, duem1, duem2, duem3, duem4, duem5, duem6, duem7, duem8, duem9, duem10, duem11, duem12,flag) values ('''||preyear||''', '''||pcode||''', '''||dcode||''', '||duem1||', '||duem2||', '||duem3||', '||duem4||', '||duem5||', '||duem6||', '||duem7||', '||duem8||', '||duem9||', '||duem10||', '||duem11||', '||duem12||',1)'; 		
	ELSEIF rowexist = TRUE THEN
		EXECUTE 'UPDATE consumptioncompliance set duem1 = '||duem1||', duem2 = '||duem2||', duem3 = '||duem3||', duem4 = '||duem4||', duem5 = '||duem5||', duem6 = '||duem6||', duem7 = '||duem7||', duem8 = '||duem8||', duem9 = '||duem9||', duem10 = '||duem10||', duem11 = '||duem11||', duem12 = '||duem12||',flag=1  WHERE year = '''||preyear||''' AND distcode = '''||dcode||''' AND procode = '''||pcode||''' ';   	
	END IF;

     SELECT exists(SELECT * FROM vaccinationcompliance WHERE year = preyear::text AND distcode = dcode AND procode = pcode) into rowexist;
	IF rowexist = FALSE THEN
		EXECUTE 'INSERT INTO vaccinationcompliance (year, procode, distcode, duem1, duem2, duem3, duem4, duem5, duem6, duem7, duem8, duem9, duem10, duem11, duem12,flag) values ('''||preyear||''', '''||pcode||''', '''||dcode||''', '||duem1||', '||duem2||', '||duem3||', '||duem4||', '||duem5||', '||duem6||', '||duem7||', '||duem8||', '||duem9||', '||duem10||', '||duem11||', '||duem12||',1)'; 
	ELSEIF rowexist = TRUE THEN
		EXECUTE 'UPDATE vaccinationcompliance set duem1 = '||duem1||', duem2 = '||duem2||', duem3 = '||duem3||', duem4 = '||duem4||', duem5 = '||duem5||', duem6 = '||duem6||', duem7 = '||duem7||', duem8 = '||duem8||', duem9 = '||duem9||', duem10 = '||duem10||', duem11 = '||duem11||', duem12 = '||duem12||',flag=1  WHERE year = '''||preyear||''' AND distcode = '''||dcode||''' AND procode = '''||pcode||''' ';   
	END IF; 
     PERFORM update_monthwise_district_sub__tsub_reports_in_vac_compliances(preyear::text,dcode,pcode); 
     PERFORM update_monwise_district_sub__tsub_reports_in_consum_compliances(preyear::text,dcode,pcode); 
     PERFORM UPDATE_weekly_wise_district_due_zero_reportcompliance_update(preyear::text,dcode,pcode);
    
 END LOOP;
     
   RETURN OLD;
END;$$;


ALTER FUNCTION public.update_monthwise_district_due_reports_in_compliances() OWNER TO postgres;

--
-- Name: update_monthwise_district_due_reports_in_fac_insert_compliances(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION update_monthwise_district_due_reports_in_fac_insert_compliances() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
    rowexist boolean;
    duem1 integer;
    duem2 integer;
    duem3 integer;
    duem4 integer;
    duem5 integer;
    duem6 integer;
    duem7 integer;
    duem8 integer;
    duem9 integer;
    duem10 integer;
    duem11 integer;
    duem12 integer;
    pcode character varying(1);
    dcode character varying(3);
    preyear character varying(4);
    currentyear character varying(4);
	
BEGIN
    preyear := '2016';
    currentyear := date_part('year', CURRENT_DATE);
    pcode := substring(NEW.facode from 1 for 1);
    dcode := substring(NEW.facode from 1 for 3);

FOR preyear IN preyear..currentyear LOOP
    duem1 := get_monthly_fstatus_vacc(preyear||'-01',dcode)::integer;
    duem2 := get_monthly_fstatus_vacc(preyear||'-02',dcode)::integer;
    duem3 := get_monthly_fstatus_vacc(preyear||'-03',dcode)::integer;
    duem4 := get_monthly_fstatus_vacc(preyear||'-04',dcode)::integer;
    duem5 := get_monthly_fstatus_vacc(preyear||'-05',dcode)::integer;
    duem6 := get_monthly_fstatus_vacc(preyear||'-06',dcode)::integer;
    duem7 := get_monthly_fstatus_vacc(preyear||'-07',dcode)::integer;
    duem8 := get_monthly_fstatus_vacc(preyear||'-08',dcode)::integer;
    duem9 := get_monthly_fstatus_vacc(preyear||'-09',dcode)::integer;
    duem10 := get_monthly_fstatus_vacc(preyear||'-10',dcode)::integer;
    duem11 := get_monthly_fstatus_vacc(preyear||'-11',dcode)::integer;
    duem12 := get_monthly_fstatus_vacc(preyear||'-12',dcode)::integer;

SELECT exists(SELECT * FROM consumptioncompliance WHERE year = preyear::text AND distcode = dcode AND procode = pcode) into rowexist;
	IF rowexist = FALSE THEN
		EXECUTE 'INSERT INTO consumptioncompliance (year, procode, distcode, duem1, duem2, duem3, duem4, duem5, duem6, duem7, duem8, duem9, duem10, duem11, duem12,flag) values ('''||preyear||''', '''||pcode||''', '''||dcode||''', '||duem1||', '||duem2||', '||duem3||', '||duem4||', '||duem5||', '||duem6||', '||duem7||', '||duem8||', '||duem9||', '||duem10||', '||duem11||', '||duem12||',1)'; 		
	ELSEIF rowexist = TRUE THEN
		EXECUTE 'UPDATE consumptioncompliance set duem1 = '||duem1||', duem2 = '||duem2||', duem3 = '||duem3||', duem4 = '||duem4||', duem5 = '||duem5||', duem6 = '||duem6||', duem7 = '||duem7||', duem8 = '||duem8||', duem9 = '||duem9||', duem10 = '||duem10||', duem11 = '||duem11||', duem12 = '||duem12||',flag=1  WHERE year = '''||preyear||''' AND distcode = '''||dcode||''' AND procode = '''||pcode||''' ';   	
	END IF;

     SELECT exists(SELECT * FROM vaccinationcompliance WHERE year = preyear::text AND distcode = dcode AND procode = pcode) into rowexist;
	IF rowexist = FALSE THEN
		EXECUTE 'INSERT INTO vaccinationcompliance (year, procode, distcode, duem1, duem2, duem3, duem4, duem5, duem6, duem7, duem8, duem9, duem10, duem11, duem12,flag) values ('''||preyear||''', '''||pcode||''', '''||dcode||''', '||duem1||', '||duem2||', '||duem3||', '||duem4||', '||duem5||', '||duem6||', '||duem7||', '||duem8||', '||duem9||', '||duem10||', '||duem11||', '||duem12||',1)'; 
	ELSEIF rowexist = TRUE THEN
		EXECUTE 'UPDATE vaccinationcompliance set duem1 = '||duem1||', duem2 = '||duem2||', duem3 = '||duem3||', duem4 = '||duem4||', duem5 = '||duem5||', duem6 = '||duem6||', duem7 = '||duem7||', duem8 = '||duem8||', duem9 = '||duem9||', duem10 = '||duem10||', duem11 = '||duem11||', duem12 = '||duem12||',flag=1  WHERE year = '''||preyear||''' AND distcode = '''||dcode||''' AND procode = '''||pcode||''' ';   
	END IF; 
     PERFORM update_monthwise_district_sub__tsub_reports_in_vac_compliances(preyear::text,dcode,pcode); 
     PERFORM update_monwise_district_sub__tsub_reports_in_consum_compliances(preyear::text,dcode,pcode);
      PERFORM UPDATE_weekly_wise_district_due_zero_reportcompliance_update(preyear::text,dcode,pcode); 
     
 END LOOP;
   RETURN OLD;
END;$$;


ALTER FUNCTION public.update_monthwise_district_due_reports_in_fac_insert_compliances() OWNER TO postgres;

--
-- Name: update_monthwise_district_sub__tsub_reports_in_vac_compliances(character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION update_monthwise_district_sub__tsub_reports_in_vac_compliances(preyear character varying, dcode character varying, pcode character varying) RETURNS void
    LANGUAGE plpgsql
    AS $$DECLARE
    rowexist boolean;
    subm1 integer;
    subm2 integer;
    subm3 integer;
    subm4 integer;
    subm5 integer;
    subm6 integer;
    subm7 integer;
    subm8 integer;
    subm9 integer;
    subm10 integer;
    subm11 integer;
    subm12 integer;
	
    tsubm1 integer;
    tsubm2 integer;
    tsubm3 integer;
    tsubm4 integer;
    tsubm5 integer;
    tsubm6 integer;
    tsubm7 integer;
    tsubm8 integer;
    tsubm9 integer;
    tsubm10 integer;
    tsubm11 integer;
    tsubm12 integer;

BEGIN
      subm1 := get_monthly_subm_vacc(preyear||'-01',dcode)::integer;
    subm2 := get_monthly_subm_vacc(preyear||'-02',dcode)::integer;
    subm3 := get_monthly_subm_vacc(preyear||'-03',dcode)::integer;
    subm4 := get_monthly_subm_vacc(preyear||'-04',dcode)::integer;
    subm5 := get_monthly_subm_vacc(preyear||'-05',dcode)::integer;
    subm6 := get_monthly_subm_vacc(preyear||'-06',dcode)::integer;
    subm7 := get_monthly_subm_vacc(preyear||'-07',dcode)::integer;
    subm8 := get_monthly_subm_vacc(preyear||'-08',dcode)::integer;
    subm9 := get_monthly_subm_vacc(preyear||'-09',dcode)::integer;
    subm10 := get_monthly_subm_vacc(preyear||'-10',dcode)::integer;
    subm11 := get_monthly_subm_vacc(preyear||'-11',dcode)::integer;
    subm12 := get_monthly_subm_vacc(preyear||'-12',dcode)::integer;

    tsubm1 := get_monthly_tsubm_vacc(preyear||'-01',dcode)::integer;
    tsubm2 := get_monthly_tsubm_vacc(preyear||'-02',dcode)::integer;
    tsubm3 := get_monthly_tsubm_vacc(preyear||'-03',dcode)::integer;
    tsubm4 := get_monthly_tsubm_vacc(preyear||'-04',dcode)::integer;
    tsubm5 := get_monthly_tsubm_vacc(preyear||'-05',dcode)::integer;
    tsubm6 := get_monthly_tsubm_vacc(preyear||'-06',dcode)::integer;
    tsubm7 := get_monthly_tsubm_vacc(preyear||'-07',dcode)::integer;
    tsubm8 := get_monthly_tsubm_vacc(preyear||'-08',dcode)::integer;
    tsubm9 := get_monthly_tsubm_vacc(preyear||'-09',dcode)::integer;
    tsubm10 := get_monthly_tsubm_vacc(preyear||'-10',dcode)::integer;
    tsubm11 := get_monthly_tsubm_vacc(preyear||'-11',dcode)::integer;
    tsubm12 := get_monthly_tsubm_vacc(preyear||'-12',dcode)::integer;
     SELECT exists(SELECT * FROM vaccinationcompliance WHERE year = preyear::text AND distcode = dcode AND procode = pcode) into rowexist;
	IF rowexist = FALSE THEN
		EXECUTE 'INSERT INTO vaccinationcompliance (year, procode, distcode,subm1, subm2, subm3, subm4, subm5, subm6, subm7, subm8, subm9, subm10, subm11, subm12, tsubm1, tsubm2, tsubm3, tsubm4, tsubm5, tsubm6, tsubm7, tsubm8, tsubm9, tsubm10, tsubm11, tsubm12) values ('''||preyear||''', '''||pcode||''', '''||dcode||''', '||subm1||', '||subm2||', '||subm3||', '||subm4||', '||subm5||', '||subm6||', '||subm7||', '||subm8||', '||subm9||', '||subm10||', '||subm11||', '||subm12||', '||tsubm1||', '||tsubm2||', '||tsubm3||', '||tsubm4||', '||tsubm5||', '||tsubm6||', '||tsubm7||', '||tsubm8||', '||tsubm9||', '||tsubm10||', '||tsubm11||', '||tsubm12||')'; 
	ELSEIF rowexist = TRUE THEN
		EXECUTE 'UPDATE vaccinationcompliance set  subm1 = '||subm1||', subm2 = '||subm2||', subm3 = '||subm3||', subm4 = '||subm4||', subm5 = '||subm5||', subm6 = '||subm6||', subm7 = '||subm7||', subm8 = '||subm8||', subm9 = '||subm9||', subm10 = '||subm10||', subm11 = '||subm11||', subm12 = '||subm12||', tsubm1 = '||tsubm1||', tsubm2 = '||tsubm2||', tsubm3 = '||tsubm3||', tsubm4 = '||tsubm4||', tsubm5 = '||tsubm5||', tsubm6 = '||tsubm6||', tsubm7 = '||tsubm7||', tsubm8 = '||tsubm8||', tsubm9 = '||tsubm9||', tsubm10 = '||tsubm10||', tsubm11 = '||tsubm11||', tsubm12 = '||tsubm12||' WHERE year = '''||preyear||''' AND distcode = '''||dcode||''' AND procode = '''||pcode||''' ';   
	END IF; 
END;$$;


ALTER FUNCTION public.update_monthwise_district_sub__tsub_reports_in_vac_compliances(preyear character varying, dcode character varying, pcode character varying) OWNER TO postgres;

--
-- Name: update_monwise_district_sub__tsub_reports_in_consum_compliances(character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION update_monwise_district_sub__tsub_reports_in_consum_compliances(preyear character varying, dcode character varying, pcode character varying) RETURNS void
    LANGUAGE plpgsql
    AS $$DECLARE
    rowexist boolean;
    subm1 integer;
    subm2 integer;
    subm3 integer;
    subm4 integer;
    subm5 integer;
    subm6 integer;
    subm7 integer;
    subm8 integer;
    subm9 integer;
    subm10 integer;
    subm11 integer;
    subm12 integer;
	
    tsubm1 integer;
    tsubm2 integer;
    tsubm3 integer;
    tsubm4 integer;
    tsubm5 integer;
    tsubm6 integer;
    tsubm7 integer;
    tsubm8 integer;
    tsubm9 integer;
    tsubm10 integer;
    tsubm11 integer;
    tsubm12 integer;

BEGIN
      subm1 := get_monthly_subm_consump(preyear||'-01',dcode)::integer;
    subm2 := get_monthly_subm_consump(preyear||'-02',dcode)::integer;
    subm3 := get_monthly_subm_consump(preyear||'-03',dcode)::integer;
    subm4 := get_monthly_subm_consump(preyear||'-04',dcode)::integer;
    subm5 := get_monthly_subm_consump(preyear||'-05',dcode)::integer;
    subm6 := get_monthly_subm_consump(preyear||'-06',dcode)::integer;
    subm7 := get_monthly_subm_consump(preyear||'-07',dcode)::integer;
    subm8 := get_monthly_subm_consump(preyear||'-08',dcode)::integer;
    subm9 := get_monthly_subm_consump(preyear||'-09',dcode)::integer;
    subm10 := get_monthly_subm_consump(preyear||'-10',dcode)::integer;
    subm11 := get_monthly_subm_consump(preyear||'-11',dcode)::integer;
    subm12 := get_monthly_subm_consump(preyear||'-12',dcode)::integer;

    tsubm1 := get_monthly_tsubm_consump(preyear||'-01',dcode)::integer;
    tsubm2 := get_monthly_tsubm_consump(preyear||'-02',dcode)::integer;
    tsubm3 := get_monthly_tsubm_consump(preyear||'-03',dcode)::integer;
    tsubm4 := get_monthly_tsubm_consump(preyear||'-04',dcode)::integer;
    tsubm5 := get_monthly_tsubm_consump(preyear||'-05',dcode)::integer;
    tsubm6 := get_monthly_tsubm_consump(preyear||'-06',dcode)::integer;
    tsubm7 := get_monthly_tsubm_consump(preyear||'-07',dcode)::integer;
    tsubm8 := get_monthly_tsubm_consump(preyear||'-08',dcode)::integer;
    tsubm9 := get_monthly_tsubm_consump(preyear||'-09',dcode)::integer;
    tsubm10 := get_monthly_tsubm_consump(preyear||'-10',dcode)::integer;
    tsubm11 := get_monthly_tsubm_consump(preyear||'-11',dcode)::integer;
    tsubm12 := get_monthly_tsubm_consump(preyear||'-12',dcode)::integer;
     SELECT exists(SELECT * FROM consumptioncompliance WHERE year = preyear::text AND distcode = dcode AND procode = pcode) into rowexist;
	IF rowexist = FALSE THEN
		EXECUTE 'INSERT INTO consumptioncompliance(year, procode, distcode,subm1, subm2, subm3, subm4, subm5, subm6, subm7, subm8, subm9, subm10, subm11, subm12, tsubm1, tsubm2, tsubm3, tsubm4, tsubm5, tsubm6, tsubm7, tsubm8, tsubm9, tsubm10, tsubm11, tsubm12) values ('''||preyear||''', '''||pcode||''', '''||dcode||''', '||subm1||', '||subm2||', '||subm3||', '||subm4||', '||subm5||', '||subm6||', '||subm7||', '||subm8||', '||subm9||', '||subm10||', '||subm11||', '||subm12||', '||tsubm1||', '||tsubm2||', '||tsubm3||', '||tsubm4||', '||tsubm5||', '||tsubm6||', '||tsubm7||', '||tsubm8||', '||tsubm9||', '||tsubm10||', '||tsubm11||', '||tsubm12||')'; 
	ELSEIF rowexist = TRUE THEN
		EXECUTE 'UPDATE consumptioncompliance set  subm1 = '||subm1||', subm2 = '||subm2||', subm3 = '||subm3||', subm4 = '||subm4||', subm5 = '||subm5||', subm6 = '||subm6||', subm7 = '||subm7||', subm8 = '||subm8||', subm9 = '||subm9||', subm10 = '||subm10||', subm11 = '||subm11||', subm12 = '||subm12||', tsubm1 = '||tsubm1||', tsubm2 = '||tsubm2||', tsubm3 = '||tsubm3||', tsubm4 = '||tsubm4||', tsubm5 = '||tsubm5||', tsubm6 = '||tsubm6||', tsubm7 = '||tsubm7||', tsubm8 = '||tsubm8||', tsubm9 = '||tsubm9||', tsubm10 = '||tsubm10||', tsubm11 = '||tsubm11||', tsubm12 = '||tsubm12||' WHERE year = '''||preyear||''' AND distcode = '''||dcode||''' AND procode = '''||pcode||''' ';   
	END IF; 
END;$$;


ALTER FUNCTION public.update_monwise_district_sub__tsub_reports_in_consum_compliances(preyear character varying, dcode character varying, pcode character varying) OWNER TO postgres;

--
-- Name: update_weekly_wise_district_due_zero_reportcompliance_update(character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION update_weekly_wise_district_due_zero_reportcompliance_update(preyear character varying, dcode character varying, pcode character varying) RETURNS void
    LANGUAGE plpgsql
    AS $$DECLARE
    rowexist boolean;
    fwk character varying;
    wkno int[];
    weekno text;
   
     x int;
    duecolumn text;
    subcolumn text; 
    tsubcolumn text;  
    duevalue  integer;
    subvalue  integer;
    tsubvalue  integer;
    
	
BEGIN
   
     
   SELECT string_agg(SUBSTRING(fweek,6,2)::TEXT,',') from epi_weeks where year=preyear  into weekno ;
   wkno=string_to_array(weekno,',')::INT[];   
   FOREACH x IN ARRAY wkno
        LOOP
   fwk := preyear||'-'||TRIM(BOTH ' ' from TO_CHAR(x,'00'));
   duevalue := zeroreport_due(fwk,dcode);
   subvalue := zeroreport_sub(fwk,dcode);
   tsubvalue := zeroreport_tsub(fwk,dcode);
   IF (x < 10 ) THEN
     duecolumn := 'duewk'||'0'||x;
     subcolumn := 'subwk'||'0'||x;
     tsubcolumn := 'tsubwk'||'0'||x;
  ELSE
     duecolumn := 'duewk'||x;
     subcolumn := 'subwk'||x;
     tsubcolumn := 'tsubwk'||x;
 
 END IF;
    
  
   
SELECT exists(SELECT * FROM zeroreportcompliance WHERE year = preyear AND distcode = dcode AND procode = pcode) into rowexist;
 
	IF rowexist = FALSE THEN
		EXECUTE 'INSERT INTO zeroreportcompliance (year, procode, distcode,'||duecolumn||','||subcolumn||','||tsubcolumn||',flag) values ('''||preyear||''', '''||pcode||''', '''||dcode||''', '||duevalue||', '||subvalue||', '||tsubvalue||',1)'; 		
	ELSEIF rowexist = TRUE THEN
		EXECUTE 'UPDATE zeroreportcompliance set '||duecolumn||'= '||duevalue||','||subcolumn||'= '||subvalue||','||tsubcolumn||'= '||tsubvalue||',flag=1  WHERE year = '''||preyear||''' AND distcode = '''||dcode||''' AND procode = '''||pcode||''' ';   	
	END IF;
      
    END LOOP;
   
END;$$;


ALTER FUNCTION public.update_weekly_wise_district_due_zero_reportcompliance_update(preyear character varying, dcode character varying, pcode character varying) OWNER TO postgres;

--
-- Name: vaccinationcompliance_delete(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION vaccinationcompliance_delete() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
rowexist boolean;
duecolumnname text;
subcolumnname text;
tsubcolumnname text;
duecount integer;
subcount integer;
timelycount integer;

BEGIN
duecount := get_monthly_fstatus_vacc(OLD.fmonth,OLD.distcode);
subcount := get_monthly_subm_vacc(OLD.fmonth,OLD.distcode);
timelycount := get_monthly_tsubm_vacc(OLD.fmonth,OLD.distcode);
subcolumnname := 'subm'||substring(OLD.fmonth from 6 for 2)::numeric;
tsubcolumnname := 'tsubm'||substring(OLD.fmonth from 6 for 2)::numeric;
duecolumnname := 'duem'||substring(OLD.fmonth from 6 for 2)::numeric;

select exists(select * from vaccinationcompliance where year=substring(OLD.fmonth from 1 for 4) and distcode=OLD.distcode and procode=OLD.procode) into rowexist;
IF rowexist = TRUE THEN
      EXECUTE 'UPDATE vaccinationcompliance set '||subcolumnname||' = '''||subcount||''', '||duecolumnname||' = '''||duecount||''',  '||tsubcolumnname||' ='''||timelycount ||''',flag=1  where year = '''||substring(OLD.fmonth from 1 for 4)||''' and distcode = '''||OLD.distcode||''' and procode = '''||OLD.procode||''' ';
END IF;
 RETURN OLD;
END;$$;


ALTER FUNCTION public.vaccinationcompliance_delete() OWNER TO postgres;

--
-- Name: vaccinationcompliance_insert(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION vaccinationcompliance_insert() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
rowexist boolean;
duecolumnname text;
subcolumnname text;
tsubcolumnname text;
duecount integer;
subcount integer;
timelycount integer;
BEGIN
duecount := get_monthly_fstatus_vacc(NEW.fmonth,NEW.distcode);
subcount := get_monthly_subm_vacc(NEW.fmonth,NEW.distcode);
timelycount := get_monthly_tsubm_vacc(NEW.fmonth,NEW.distcode);
subcolumnname := 'subm'||substring(NEW.fmonth from 6 for 2)::numeric;
tsubcolumnname := 'tsubm'||substring(NEW.fmonth from 6 for 2)::numeric;
duecolumnname := 'duem'||substring(NEW.fmonth from 6 for 2)::numeric;

select exists(select * from vaccinationcompliance where year=substring(NEW.fmonth from 1 for 4) and distcode=NEW.distcode and procode=NEW.procode) into rowexist;
IF rowexist = FALSE THEN
	EXECUTE 'INSERT INTO vaccinationcompliance (year,'||duecolumnname||', '||subcolumnname||', '||tsubcolumnname||',procode,distcode,flag) values ('''||substring(NEW.fmonth from 1 for 4)||''','''||duecount||''','''||subcount||''','''||timelycount ||''','''||NEW.procode||''','''||NEW.distcode||''',1)';
ELSEIF rowexist = TRUE THEN
        EXECUTE 'UPDATE vaccinationcompliance set '||subcolumnname||' = '''||subcount||''', '||duecolumnname||' = '''||duecount||''',  '||tsubcolumnname||' ='''||timelycount ||''',flag=1  where year = '''||substring(NEW.fmonth from 1 for 4)||''' and distcode = '''||NEW.distcode||''' and procode = '''||NEW.procode||''' ';
END IF;
 RETURN NEW;
END;$$;


ALTER FUNCTION public.vaccinationcompliance_insert() OWNER TO postgres;

--
-- Name: vaccinationcompliance_update(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION vaccinationcompliance_update() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE

rowexist boolean;
timelyincrement integer;
tsubcolumnname text;
duecolumnname text;
subcolumnname text;
duecount integer;
subcount integer;
timelycount integer;

BEGIN

tsubcolumnname := 'tsubm'||substring(NEW.fmonth from 6 for 2)::numeric;
duecolumnname := 'duem'||substring(NEW.fmonth from 6 for 2)::numeric;
subcolumnname := 'subm'||substring(NEW.fmonth from 6 for 2)::numeric;
duecount := get_monthly_fstatus_vacc(NEW.fmonth,NEW.distcode);
subcount := get_monthly_subm_vacc(NEW.fmonth,NEW.distcode);
timelycount := get_monthly_tsubm_vacc(NEW.fmonth,NEW.distcode);

   select exists(select * from vaccinationcompliance where year=substring(NEW.fmonth from 1 for 4) and distcode=NEW.distcode and procode=NEW.procode) into rowexist;
IF rowexist = TRUE THEN
    EXECUTE 'UPDATE vaccinationcompliance set '||subcolumnname||' = '''||subcount||''', '||duecolumnname||' = '''||duecount||''',  '||tsubcolumnname||' ='''||timelycount ||''',flag=1  where year = '''||substring(NEW.fmonth from 1 for 4)||''' and distcode = '''||NEW.distcode||''' and procode = '''||NEW.procode||''' ';
  END IF;
      IF NEW.fmonth!= OLD.fmonth THEN
    tsubcolumnname := 'tsubm'||substring(OLD.fmonth from 6 for 2)::numeric;
    duecolumnname := 'duem'||substring(OLD.fmonth from 6 for 2)::numeric;
    subcolumnname := 'subm'||substring(OLD.fmonth from 6 for 2)::numeric;
    duecount := get_monthly_fstatus_vacc(OLD.fmonth,OLD.distcode);
    subcount := get_monthly_subm_vacc(OLD.fmonth,OLD.distcode);
    timelycount := get_monthly_tsubm_vacc(OLD.fmonth,OLD.distcode);
     select exists(select * from vaccinationcompliance where year=substring(OLD.fmonth from 1 for 4) and distcode=OLD.distcode and procode=OLD.procode) into rowexist;
             IF rowexist = TRUE THEN
    EXECUTE 'UPDATE vaccinationcompliance set '||subcolumnname||' = '''||subcount||''', '||duecolumnname||' = '''||duecount||''',  '||tsubcolumnname||' ='''||timelycount ||''',flag=1  where year = '''||substring(OLD.fmonth from 1 for 4)||''' and distcode = '''||OLD.distcode||''' and procode = '''||OLD.procode||''' ';
              END IF;
  END IF;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.vaccinationcompliance_update() OWNER TO postgres;

--
-- Name: vaccine_usagerate(character varying, character varying, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION vaccine_usagerate(ffmonth character varying, code character varying, consumption_id integer, vaccineid integer) RETURNS double precision
    LANGUAGE plpgsql
    AS $_$DECLARE
   rate double precision;
   whereText text;
   openingbalance integer;
   received integer;
   closingbalance integer;
   childrenVaccinated integer;
   monthpart integer;
   yearpart integer;
   vaccinationid integer;
   
       BEGIN
           
            IF vaccineid= 4 THEN
               vaccinationid := 7;
            ELSIF vaccineid= 5 THEN
               vaccinationid := 10;
            ELSIF vaccineid= 6 THEN
               vaccinationid := 16;
            ELSIF vaccineid= 10 THEN
               vaccinationid := 2;
            ELSIF vaccineid= 11 THEN
               vaccinationid := 13;
            ELSIF vaccineid= 18 THEN
               vaccinationid := 14;
            ELSE
               vaccinationid := vaccineid;
            END IF;
           

            IF character_length(code) = '1' THEN
               whereText := 'procode';
            ELSIF character_length(code) = '3' THEN
               whereText := 'distcode';
            ELSIF character_length(code) = '6' THEN
               whereText := 'facode';
            ELSIF character_length(code) = '9' THEN
               whereText := 'uncode';
            ELSE
               return 0;
            END IF;
            EXECUTE ' SELECT SUM(opening_doses) FROM epi_consumption_master  master left join epi_consumption_detail detail on master.pk_id=detail.main_id  where item_id='||$3||' and fmonth='''||ffmonth||''' and '||whereText||'='''||code||''' ' INTO openingbalance; 
            EXECUTE ' SELECT SUM(received_doses) FROM epi_consumption_master  master left join epi_consumption_detail detail on master.pk_id=detail.main_id  where item_id='||$3||' and fmonth='''||ffmonth||''' and '||whereText||'='''||code||''' ' INTO received ;
           EXECUTE ' SELECT SUM(closing_doses) FROM epi_consumption_master  master left join epi_consumption_detail detail on master.pk_id=detail.main_id  where item_id='||$3||' and fmonth='''||ffmonth||''' and '||whereText||'='''||code||''' ' INTO closingbalance ;
           
            yearpart := split_part(ffmonth,'-',1);
            monthpart := split_part(ffmonth,'-',2);
            IF monthpart = 1 THEN
               monthpart := 12;
               yearpart := yearpart-1;
            ELSE
               monthpart := monthpart-1;
            END IF;
            
            ffmonth := yearpart||'-'||LTRIM(to_char(monthpart,'09'),' ');
            childrenVaccinated := getmonthlyvaccination(ffmonth,code,vaccinationid);

            rate := (childrenVaccinated * 100)::double precision/NULLIF(((openingbalance+received)-(closingbalance))::double precision,0);
            IF rate < 0 THEN
               rate := 0;
            END IF;
            RETURN rate;
       END;

$_$;


ALTER FUNCTION public.vaccine_usagerate(ffmonth character varying, code character varying, consumption_id integer, vaccineid integer) OWNER TO postgres;

--
-- Name: FUNCTION vaccine_usagerate(ffmonth character varying, code character varying, consumption_id integer, vaccineid integer); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION vaccine_usagerate(ffmonth character varying, code character varying, consumption_id integer, vaccineid integer) IS 'according to new consumption table ';


--
-- Name: vaccine_wastagerate(character varying, character varying, integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION vaccine_wastagerate(ffmonth character varying, code character varying, consumption_id integer, vaccineid integer) RETURNS double precision
    LANGUAGE plpgsql
    AS $$DECLARE
   rate double precision;
      BEGIN
         rate := 100 - vaccine_usagerate(ffmonth,code,consumption_id,vaccineid);
         IF rate < 0 THEN
            rate := 0;
         END IF;
         RETURN rate;
      END;$$;


ALTER FUNCTION public.vaccine_wastagerate(ffmonth character varying, code character varying, consumption_id integer, vaccineid integer) OWNER TO postgres;

--
-- Name: FUNCTION vaccine_wastagerate(ffmonth character varying, code character varying, consumption_id integer, vaccineid integer); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION vaccine_wastagerate(ffmonth character varying, code character varying, consumption_id integer, vaccineid integer) IS 'according to new consumption table ';


--
-- Name: villagename(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION villagename(villagecode text) RETURNS text
    LANGUAGE plpgsql
    AS $$DECLARE
        villagename text;
    BEGIN
	SELECT village into villagename from villages where vcode=villagecode;
        RETURN villagename;
    END;$$;


ALTER FUNCTION public.villagename(villagecode text) OWNER TO postgres;

--
-- Name: vouchers(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION vouchers(master_id integer) RETURNS integer[]
    LANGUAGE plpgsql
    AS $$DECLARE
     recievevoucher int[];
     batchpkid text;
     batchpkidarr int[];
     voucher character varying='';
     i int=0;
     x int;
     
BEGIN
     SELECT string_agg(distinct(batch_master_id)::TEXT,',') from epi_stock_batch where status='Stacked' and parent_pk_id IN (SELECT pk_id from epi_Stock_batch where batch_master_id=master_id) into batchpkid;
        batchpkidarr=string_to_array(batchpkid,',');
       FOREACH x IN ARRAY batchpkidarr
        LOOP
          
           SELECT SUBSTRING (transaction_number,2) from epi_stock_master where pk_id=x and transaction_type_id=1 into voucher;
           recievevoucher[i] =voucher;
           i=i+1;
          
        END LOOP;
          
     return recievevoucher;
END$$;


ALTER FUNCTION public.vouchers(master_id integer) OWNER TO postgres;

--
-- Name: warehousetypename(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION warehousetypename(whcode integer) RETURNS text
    LANGUAGE plpgsql
    AS $$ DECLARE
     whname text;
   BEGIN
    SELECT warehouse_type_name into whname from epi_cc_warehouse_types where pk_id=whcode;
   RETURN whname;
   END$$;


ALTER FUNCTION public.warehousetypename(whcode integer) OWNER TO postgres;

--
-- Name: zero_report_submitted_rate(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION zero_report_submitted_rate(fweekk character varying, code character varying) RETURNS double precision
    LANGUAGE plpgsql
    AS $$DECLARE
       rate double precision;
       total_expected_reports integer;
       total_timely_submitted_reports integer;
       whereText text;
          BEGIN
            IF character_length(code) = '1' THEN
               whereText := 'procode';
            ELSIF character_length(code) = '3' THEN
               whereText := 'distcode';
            ELSIF character_length(code) = '6' THEN
               whereText := 'facode';
            ELSIF character_length(code) = '9' THEN
               whereText := 'uncode';
            ELSE
               return 0;
            END IF;

            EXECUTE 'SELECT sum(case when getfstatus_ds('''||fweekk||''',facode)=''F'' then 1 else 0 end) FROM facilities WHERE '||whereText||'='''||code||''' AND hf_type=''e'' AND is_ds_fac=''1'' ' INTO total_expected_reports;
            EXECUTE 'SELECT COUNT(*) FROM zero_report JOIN facilities ON zero_report.facode=facilities.facode WHERE facilities.'||whereText||'='''||code||''' AND getfstatus_ds('''||fweekk||''',zero_report.facode)=''F'' AND zero_report.fweek='''||fweekk||''' AND report_submitted=''1'' AND zero_report.submitted_date IS NOT NULL and week::numeric > 0 ' INTO total_timely_submitted_reports;

            rate := ((total_timely_submitted_reports::double precision/NULLIF(total_expected_reports,0)::double precision)*100)::double precision;
         RETURN rate;
      END;$$;


ALTER FUNCTION public.zero_report_submitted_rate(fweekk character varying, code character varying) OWNER TO postgres;

--
-- Name: zero_report_timely_submitted_rate(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION zero_report_timely_submitted_rate(fweekk character varying, code character varying) RETURNS double precision
    LANGUAGE plpgsql
    AS $$DECLARE
       rate double precision;
       total_expected_reports integer;
       total_timely_submitted_reports integer;
       whereText text;
          BEGIN
            IF character_length(code) = '1' THEN
               whereText := 'procode';
            ELSIF character_length(code) = '3' THEN
               whereText := 'distcode';
            ELSIF character_length(code) = '6' THEN
               whereText := 'facode';
            ELSIF character_length(code) = '9' THEN
               whereText := 'uncode';
            ELSE
               return 0;
            END IF;

            EXECUTE 'SELECT sum(case when getfstatus_ds('''||fweekk||''',facode)=''F'' then 1 else 0 end) FROM facilities WHERE '||whereText||'='''||code||''' AND hf_type=''e'' AND is_ds_fac=''1'' ' INTO total_expected_reports;
            EXECUTE 'SELECT COUNT(*) FROM zero_report JOIN facilities ON zero_report.facode=facilities.facode WHERE facilities.'||whereText||'='''||code||''' AND zero_report.fweek='''||fweekk||''' AND report_submitted=''1'' and getfstatus_ds('''||fweekk||''',zero_report.facode)=''F'' AND zero_report.submitted_date IS NOT NULL and week::numeric > 0 ' INTO total_timely_submitted_reports;

            rate := ((total_timely_submitted_reports::double precision/NULLIF(total_expected_reports,0)::double precision)*100)::double precision;
         RETURN rate;
      END;$$;


ALTER FUNCTION public.zero_report_timely_submitted_rate(fweekk character varying, code character varying) OWNER TO postgres;

--
-- Name: zeroreport_due(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION zeroreport_due(fweekk character varying, distcodee character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
      
       total_expected_reports integer;
       
          BEGIN
   

            EXECUTE 'SELECT sum(case when getfstatus_ds('''||fweekk||''',facode)=''F'' then 1 else 0 end) FROM facilities WHERE distcode='''||distcodee||''' ' INTO total_expected_reports;

         RETURN total_expected_reports;
      END;$$;


ALTER FUNCTION public.zeroreport_due(fweekk character varying, distcodee character varying) OWNER TO postgres;

--
-- Name: zeroreport_sub(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION zeroreport_sub(fweekk character varying, distcodee character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
      
       total_sub_reports integer;
       
          BEGIN
   

            EXECUTE 'SELECT COUNT(*) FROM zero_report JOIN facilities ON zero_report.facode=facilities.facode WHERE facilities.distcode='''||distcodee||''' AND zero_report.fweek='''||fweekk||''' AND report_submitted=''1''  and getfstatus_ds('''||fweekk||''',zero_report.facode)=''F'' and week::numeric > 0' INTO total_sub_reports ;

         RETURN total_sub_reports ;
      END;$$;


ALTER FUNCTION public.zeroreport_sub(fweekk character varying, distcodee character varying) OWNER TO postgres;

--
-- Name: zeroreport_tsub(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION zeroreport_tsub(fweekk character varying, distcodee character varying) RETURNS integer
    LANGUAGE plpgsql
    AS $$DECLARE
      
       total_timely_reports integer;
       
          BEGIN
   

            EXECUTE 'SELECT COUNT(*) FROM zero_report JOIN facilities ON zero_report.facode=facilities.facode WHERE facilities.distcode='''||distcodee||''' AND zero_report.fweek='''||fweekk||''' AND report_submitted=''1'' AND zero_report.submitted_date IS NOT NULL  and getfstatus_ds('''||fweekk||''',zero_report.facode)=''F'' and week::numeric > 0' INTO total_timely_reports;

         RETURN total_timely_reports;
      END;$$;


ALTER FUNCTION public.zeroreport_tsub(fweekk character varying, distcodee character varying) OWNER TO postgres;

--
-- Name: zeroreportcompliance_delete(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION zeroreportcompliance_delete() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
rowexist boolean;
duecolumnname text;
subcolumnname text;
tsubcolumnname text;
duecount integer;
fweekk character varying;
timelycount integer;
subcount integer;
yearr integer;
weekk integer;

BEGIN
yearr := substring(OLD.fweek from 1 for 4)::numeric;
weekk := substring(OLD.fweek from 6 for 2)::numeric;
duecount := get_weekly_fstatus_ds(yearr,weekk,OLD.distcode);
fweekk :=yearr||'-'||substring(OLD.fweek from 6 for 2)::text;
subcount :=zeroreport_sub(fweekk ,OLD.distcode);
timelycount :=zeroreport_tsub(fweekk ,OLD.distcode);
subcolumnname := 'subwk'||substring(OLD.fweek from 6 for 2);
tsubcolumnname := 'tsubwk'||substring(OLD.fweek from 6 for 2);
duecolumnname := 'duewk'||substring(OLD.fweek from 6 for 2);



select exists(select * from zeroreportcompliance where year=substring(OLD.fweek from 1 for 4) and distcode=OLD.distcode and procode=OLD.procode) into rowexist;
IF rowexist = TRUE THEN
        EXECUTE 'UPDATE zeroreportcompliance set '||subcolumnname||' = '''||subcount||''','||tsubcolumnname||' = '''||timelycount ||''','||duecolumnname||' = '''||duecount||''',flag=1  where year = '''||yearr||''' and distcode = '''||OLD.distcode||''' and procode = '''||OLD.procode||''' ';
END IF;
 RETURN OLD;
END;	  $$;


ALTER FUNCTION public.zeroreportcompliance_delete() OWNER TO postgres;

--
-- Name: zeroreportcompliance_insert(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION zeroreportcompliance_insert() RETURNS trigger
    LANGUAGE plpgsql
    AS $$DECLARE
rowexist boolean;
duecolumnname text;
subcolumnname text;
tsubcolumnname text;
fweekk character varying;
duecount integer;
timelycount integer;
subcount integer;
yearr integer;
weekk integer;

BEGIN
yearr := substring(NEW.fweek from 1 for 4)::numeric;
weekk := substring(NEW.fweek from 6 for 2)::numeric;
duecount := get_weekly_fstatus_ds(yearr,weekk,NEW.distcode);
 fweekk :=yearr||'-'||substring(NEW.fweek from 6 for 2)::text;
subcount :=zeroreport_sub(fweekk ,NEW.distcode);
timelycount :=zeroreport_tsub(fweekk ,NEW.distcode);
subcolumnname := 'subwk'||substring(NEW.fweek from 6 for 2);
tsubcolumnname := 'tsubwk'||substring(NEW.fweek from 6 for 2);
duecolumnname := 'duewk'||substring(NEW.fweek from 6 for 2);


select exists(select * from zeroreportcompliance where year=substring(NEW.fweek from 1 for 4) and distcode=NEW.distcode and procode=NEW.procode) into rowexist;
IF rowexist = FALSE THEN
	EXECUTE 'INSERT INTO zeroreportcompliance (year,'||duecolumnname||', '||subcolumnname||', '||tsubcolumnname||',procode,distcode,flag) values ('''||yearr||''','''||duecount||''','''||subcount||''','''||timelycount||''','''||NEW.procode||''','''||NEW.distcode||''',1)';
ELSEIF rowexist = TRUE THEN
        EXECUTE 'UPDATE zeroreportcompliance set '||subcolumnname||' ='''||subcount||''', '||duecolumnname||' = '''||duecount||''',  '||tsubcolumnname||' ='''||timelycount||''',flag=1  where year = '''||yearr||''' and distcode = '''||NEW.distcode||''' and procode = '''||NEW.procode||''' ';
END IF;
 RETURN NEW;
END;$$;


ALTER FUNCTION public.zeroreportcompliance_insert() OWNER TO postgres;

--
-- Name: //; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR // (
    PROCEDURE = gtpb_divide,
    LEFTARG = integer,
    RIGHTARG = integer
);


ALTER OPERATOR public.// (integer, integer) OWNER TO postgres;

--
-- Name: //; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR // (
    PROCEDURE = gtpb_divide,
    LEFTARG = double precision,
    RIGHTARG = double precision
);


ALTER OPERATOR public.// (double precision, double precision) OWNER TO postgres;

--
-- Name: //; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR // (
    PROCEDURE = gtpb_divide,
    LEFTARG = double precision,
    RIGHTARG = integer
);


ALTER OPERATOR public.// (double precision, integer) OWNER TO postgres;

--
-- Name: //; Type: OPERATOR; Schema: public; Owner: postgres
--

CREATE OPERATOR // (
    PROCEDURE = gtpb_divide,
    LEFTARG = integer,
    RIGHTARG = double precision
);


ALTER OPERATOR public.// (integer, double precision) OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: abroad_cases; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--


--
-- Name: widget_filters_dashboard_widget_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY widget_filters
    ADD CONSTRAINT widget_filters_dashboard_widget_id_fkey FOREIGN KEY (dashboard_widget_id) REFERENCES dashboard_widget_detail(pk_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: widget_filters_main_filter_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY widget_filters
    ADD CONSTRAINT widget_filters_main_filter_id_fkey FOREIGN KEY (main_filter_id) REFERENCES custom_filters(pk_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: widget_indicators_indicator_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY widget_indicators
    ADD CONSTRAINT widget_indicators_indicator_id_fkey FOREIGN KEY (indicator_id) REFERENCES custom_indicators_defination(pk_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: widget_indicators_widget_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY widget_indicators
    ADD CONSTRAINT widget_indicators_widget_id_fkey FOREIGN KEY (widget_id) REFERENCES widget_type(pk_id) ON UPDATE RESTRICT ON DELETE RESTRICT;



