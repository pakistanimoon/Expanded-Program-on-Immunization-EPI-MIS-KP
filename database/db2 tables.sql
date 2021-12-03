
CREATE TABLE abroad_cases (
    pk_id integer NOT NULL,
    case_id integer NOT NULL,
    country text NOT NULL,
    departed_date date NOT NULL,
    transit_site text,
    cn_id_from integer DEFAULT 0,
    cn_id_to integer DEFAULT 0,
    cross_case_id text
);






CREATE TABLE access_types (
    pk_id integer DEFAULT nextval('access_type_sequence_id'::regclass) NOT NULL,
    name character varying(255)
);


CREATE TABLE adjustment_type (
    id integer DEFAULT nextval('adjustment_type_seq'::regclass) NOT NULL,
    type character varying(30)
);


COMMENT ON TABLE adjustment_type IS 'for adjustment of missing vaccines';



CREATE TABLE adv_report_fields (
    report_fields_id integer DEFAULT nextval('adv_report_fields_id'::regclass) NOT NULL,
    report_id integer NOT NULL,
    sec_id text,
    field_id text NOT NULL,
    module_id character varying(3)
);



CREATE TABLE adv_reports (
    report_id integer DEFAULT nextval('advance_report_id'::regclass) NOT NULL,
    report_title text NOT NULL,
    username character varying(50) NOT NULL,
    module_id character varying(3),
    tbl_select character varying(20)
);


CREATE TABLE aefi_case_investigation_form (
    id integer DEFAULT nextval('aefi_case_investigation_id_seq'::regclass) NOT NULL,
    case_epi_no character varying(30),
    date_reported date,
    date_investigation_started date,
    child_name character varying(50),
    dob date,
    gender character varying(6),
    name_cast_father character varying(100),
    address character varying(255),
    village character varying(255),
    uncode character varying(9),
    tcode character varying(6),
    distcode character varying(3),
    contact_no character varying(15),
    datetime_vaccination date,
    vacc_and_dose_no character varying(100),
    site_administration character varying(100),
    vaccination_center character varying(150),
    vaccinated_by character varying(100),
    vacc_r1_name character varying(50),
    vacc_r2_name character varying(50),
    vacc_r3_name character varying(50),
    vacc_r4_name character varying(50),
    dil_r1_name character varying(50),
    dil_r2_name character varying(50),
    vacc_r1_f1 character varying(50),
    vacc_r2_f1 character varying(50),
    vacc_r3_f1 character varying(50),
    vacc_r4_f1 character varying(50),
    dil_r1_f1 character varying(50),
    dil_r2_f1 character varying(50),
    vacc_r1_f2 character varying(50),
    vacc_r2_f2 character varying(50),
    vacc_r3_f2 character varying(50),
    vacc_r4_f2 character varying(50),
    dil_r1_f2 character varying(50),
    dil_r2_f2 character varying(50),
    vacc_r1_f3 date,
    vacc_r2_f3 date,
    vacc_r3_f3 date,
    vacc_r4_f3 date,
    dil_r1_f3 date,
    dil_r2_f3 date,
    suspected_vaccine character varying(50),
    adv_evt_detail text,
    ho_present_illness text,
    date_onset date,
    time_onset time without time zone,
    date_hospitalization date,
    time_hospitalization time without time zone,
    date_death date,
    time_death time without time zone,
    pulse integer,
    temp integer,
    bp integer,
    heart_rate integer,
    resp_rate integer,
    lungs text,
    skin_change text,
    size_skin_lesion double precision,
    cyanosis text,
    pupil text,
    kernigs_sign text,
    neck_stiffness text,
    level_consciousness text,
    lymph_node text,
    jerks text,
    cranial_nerve_abnormality text,
    other_abnormal_signs text,
    treatment text,
    provisional_diagnosis text,
    outcome text,
    pse_dd character varying(3),
    rpv_dd character varying(3),
    hoa_dd character varying(3),
    peid_dd character varying(3),
    cm_dd character varying(3),
    hohil30days_dd character varying(3),
    rhotwdt_dd character varying(3),
    fhada_dd character varying(3),
    past_similar_event text,
    reaction_previous_vaccination text,
    no_allergy text,
    pre_existing text,
    current_medication text,
    ho_hosp_cause text,
    recent_ho_trauma text,
    family_history text,
    no_cases_immunized text,
    no_cases_sae_immunized text,
    no_cases_sae_non_immunized text,
    store_temp_inside_ilr text,
    store_temp_freezer text,
    store_correct_procedure text,
    store_other_object_in_ilr text,
    store_reconstituted_vaccines text,
    store_unusable_vaccine text,
    store_unusable_diluents text,
    trans_type_vacc_carrier_used text,
    trans_vaccine_carrier_packed text,
    trans_vaccine_carrier_sent text,
    trans_vacc_carrier_from_epi text,
    trans_conditioned_icepack text,
    rec_procedure_followed text,
    rec_correct_amount_diluent text,
    rec_used_separate_syringe text,
    rec_matching_diluent_used text,
    inj_correct_dose_rate text,
    inj_non_touch_techniques text,
    inj_vial_shaked_before_inj text,
    inj_contraindication_assessed text,
    inj_aefi_reported_last30_days text,
    inj_training_by_vaccinator text,
    lab_inv_conducted text,
    lab_inv_tests text,
    pe_f1 character varying(3),
    pe_f2 character varying(3),
    pe_f3 character varying(3),
    pe_f4 character varying(3),
    pe_f5 character varying(3),
    pe_f6 character varying(3),
    vcr_f1 character varying(3),
    vcr_f2 character varying(3),
    vcr_f3 character varying(3),
    coincidental character varying(3),
    inj_reaction character varying(3),
    unknown character varying(3),
    confidence_conclusion character varying(8),
    conclusion_reason text,
    recommendation text,
    additional_notes text,
    itd_r1_name character varying(100),
    itd_r2_name character varying(100),
    itd_r3_name character varying(100),
    itd_r4_name character varying(100),
    itd_r5_name character varying(100),
    itd_r6_name character varying(100),
    itd_r7_name character varying(100),
    itd_r1_desg character varying(50),
    itd_r2_desg character varying(50),
    itd_r3_desg character varying(50),
    itd_r4_desg character varying(50),
    itd_r5_desg character varying(50),
    itd_r6_desg character varying(50),
    itd_r7_desg character varying(50),
    itd_r1_sign character varying(50),
    itd_r2_sign character varying(50),
    itd_r3_sign character varying(50),
    itd_r4_sign character varying(50),
    itd_r5_sign character varying(50),
    itd_r6_sign character varying(50),
    itd_r7_sign character varying(50),
    date_investigation_completed date,
    procode character varying(1),
    aefi_number integer,
    year integer,
    month character varying(9),
    fmonth character varying(15),
    dcode integer
);


CREATE TABLE aefi_rep (
    id integer DEFAULT nextval('aefi_rep_id_seq'::regclass) NOT NULL,
    procode character varying(1) DEFAULT 3 NOT NULL,
    distcode character varying(3) NOT NULL,
    tcode character varying(6) NOT NULL,
    uncode character varying(9) NOT NULL,
    village text,
    casename text,
    gender integer DEFAULT 0,
    dob date,
    age integer DEFAULT 0,
    years integer DEFAULT 0,
    months integer DEFAULT 0,
    weeks integer DEFAULT 0,
    fathername text,
    husbandname text,
    cellnumber text,
    mc_bcg integer DEFAULT 0,
    mc_convulsion integer DEFAULT 0,
    mc_severe integer DEFAULT 0,
    mc_unconscious integer DEFAULT 0,
    mc_abscess integer DEFAULT 0,
    mc_respiratory integer DEFAULT 0,
    mc_fever integer DEFAULT 0,
    mc_swelling integer DEFAULT 0,
    mc_rash integer DEFAULT 0,
    mc_other text,
    mc_treatment integer DEFAULT 0,
    mc_hospitalized integer DEFAULT 0,
    mc_hosp_address text,
    vacc_date date,
    vacc_name text,
    vacc_manufacturer text,
    vacc_exp date,
    vacc_center text,
    vacc_vaccinator text,
    rep_person text,
    rep_desg text,
    rep_date date,
    no_reporting_units integer,
    no_reported integer,
    no_reported_ontime integer,
    datefrom date,
    dateto date,
    week integer NOT NULL,
    no_aefi_cases integer DEFAULT 0,
    death character varying(3),
    date_aefi_onset date,
    submitted_by character varying(100),
    submitted_desg character varying(100),
    aefi_cases text,
    year integer NOT NULL,
    fwee integer NOT NULL,
    fweek character varying(7),
    submitted_date date,
    editted_date date,
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    facode character varying(6),
    vcode character varying(12),
    child_registration_no character varying(30),
    vacc_batch text,
    is_mobile_entry integer
);


COMMENT ON COLUMN aefi_rep.gender IS '0 for Female, 1 for Male';



COMMENT ON COLUMN aefi_rep.mc_bcg IS '0 for not applicable, 1 for applicable';

COMMENT ON COLUMN aefi_rep.mc_convulsion IS '0 for not applicable, 1 for applicable';


COMMENT ON COLUMN aefi_rep.mc_severe IS '0 for not applicable, 1 for applicable';


COMMENT ON COLUMN aefi_rep.mc_unconscious IS '0 for not applicable, 1 for applicable';

COMMENT ON COLUMN aefi_rep.mc_abscess IS '0 for not applicable, 1 for applicable';

COMMENT ON COLUMN aefi_rep.mc_respiratory IS '0 for not applicable, 1 for applicable';


COMMENT ON COLUMN aefi_rep.mc_fever IS '0 for not applicable, 1 for applicable';


COMMENT ON COLUMN aefi_rep.mc_swelling IS '0 for not applicable, 1 for applicable';


COMMENT ON COLUMN aefi_rep.mc_rash IS '0 for not applicable, 1 for applicable';

COMMENT ON COLUMN aefi_rep.mc_treatment IS '0 for treatment not given, 1 for treatment given';

COMMENT ON COLUMN aefi_rep.mc_hospitalized IS '0 for not applicable, 1 for applicable';

COMMENT ON COLUMN aefi_rep.rep_date IS 'report date';

COMMENT ON COLUMN aefi_rep.is_temp_saved IS '0 means form is completely filled and saved from submit button, 1 means checklist is not completed and temporarily saved for re-edit later';


CREATE TABLE afp_case_investigation (
    id integer DEFAULT nextval('afp_case_investigation_id_seq'::regclass) NOT NULL,
    facode character varying(6),
    faddress text,
    uncode character varying(9),
    tcode character varying(6),
    distcode character varying(3),
    procode character varying(1),
    year character varying(4),
    week integer,
    datefrom date,
    dateto date,
    case_reported integer DEFAULT 1 NOT NULL,
    epid_year character varying(4),
    afp_number integer,
    dcode integer,
    patient_gender character varying(1),
    patient_fathername character varying(100),
    patient_dob date,
    age_months integer DEFAULT 0,
    patient_address text,
    patient_address_uncode character varying(9),
    patient_address_tcode character varying(6),
    patient_address_distcode character varying(3),
    case_date_investigation date,
    case_date_notification date,
    case_date_onset date,
    fever_onset character varying(1),
    rapid_progression character varying(1),
    asymm_paralysis character varying(1),
    sia character varying(30),
    date_collection_s1 date,
    date_collection_s2 date,
    date_sent_lab_s1 date,
    date_sent_lab_s2 date,
    condition_s1 character varying(30),
    condition_s2 character varying(30),
    final_result_s1 character varying(30),
    final_result_s2 character varying(30),
    date_follow_up date,
    classification character varying(1),
    final_diagnosis character varying(30),
    residual_paralysis character varying(1),
    patient_name character varying(500),
    case_epi_no character varying(30),
    fweek character varying(7),
    submitted_date date,
    editted_date date,
    clinical_representation text,
    doses_received integer,
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    cross_notified integer DEFAULT 0,
    cross_notified_from_distcode character varying(3),
    rb_distcode character varying(3),
    rb_tcode character varying(6),
    rb_uncode character varying(9),
    rb_facode character varying(6),
    rb_faddress text,
    approval_status character varying(10),
    patient_address_procode character varying(1),
    cn_id_from integer DEFAULT 0,
    cn_id_to integer DEFAULT 0,
    cross_case_id text,
    contact_numb character varying(15)
);

COMMENT ON COLUMN afp_case_investigation.is_temp_saved IS '0 means form is completely filled and saved from submit button, 1 means checklist is not completed and temporarily saved for re-edit later';

CREATE TABLE afp_outbreak_linelist (
    id integer DEFAULT nextval('afp_outbreak_linelist_id_seq'::regclass) NOT NULL,
    village_mahalla character varying(50),
    distcode character varying(3),
    date_investigation date,
    uncode character varying(9),
    tcode character varying(6),
    procode character varying(1),
    investigation_by character varying(50),
    fname_father character varying(100),
    case_epi_no character varying(26),
    age_in_months integer,
    gender character varying(6),
    child_address character varying(255),
    vacc_dose_no integer,
    date_last_dose date,
    date_rash_onset date,
    date_collection_blood date,
    date_collection_throat date,
    date_follow_up date,
    date_death date,
    complication character varying(100),
    linelist_group integer DEFAULT 0,
    date_submitted date
);

CREATE TABLE arallowances (
    ar_id integer DEFAULT nextval('as_seq'::regclass) NOT NULL,
    title character varying(55),
    forsv double precision,
    fortech double precision,
    foras double precision,
    fordriver double precision
);

CREATE TABLE ardeductions (
    d_id integer DEFAULT nextval('ad_seq'::regclass) NOT NULL,
    title character varying(99),
    forsv double precision,
    fortech double precision,
    fordriver double precision,
    foras double precision
);

CREATE TABLE auto_req_cache (
    id integer DEFAULT nextval('auto_req_cache_seq'::regclass) NOT NULL,
    wh_level integer NOT NULL,
    wh_code character varying(10) NOT NULL,
    activity smallint DEFAULT 1 NOT NULL,
    item_id integer NOT NULL,
    suggested numeric,
    available numeric,
    requisition numeric,
    rec_datetime timestamp without time zone NOT NULL
);

COMMENT ON TABLE auto_req_cache IS 'this table will contain cache data for automatic requisition.';


CREATE TABLE auto_req_cache_history (
    id integer DEFAULT nextval('auto_req_cache_history_seq'::regclass) NOT NULL,
    wh_level integer NOT NULL,
    wh_code character varying(10) NOT NULL,
    activity smallint DEFAULT 1 NOT NULL,
    item_id integer NOT NULL,
    suggested numeric,
    available numeric,
    requisition numeric,
    rec_datetime timestamp without time zone NOT NULL,
    created_date timestamp without time zone DEFAULT now()
);


CREATE TABLE bankdb (
    bid character varying(6) DEFAULT nextval('bank_seq'::regclass) NOT NULL,
    bankname character varying(80),
    branchcode character varying(15),
    branchname character varying(100),
    distcode character varying(3)
);


CREATE TABLE bankinfo (
    bankid character varying(6) DEFAULT nextval('bankinfo_seq'::regclass) NOT NULL,
    bankcode character varying(8),
    bankname character varying(250)
);


CREATE TABLE campaign_purpose (
    id integer DEFAULT nextval('campain_purpose_seq'::regclass) NOT NULL,
    type character varying(50),
    product_id integer
);


CREATE TABLE case_clinical_representation (
    id integer DEFAULT nextval('case_representation_seq'::regclass) NOT NULL,
    case_type_definition text NOT NULL,
    case_type_id integer NOT NULL
);


CREATE TABLE case_investigation_db (
    id integer DEFAULT nextval('case_investigation_seq'::regclass) NOT NULL,
    facode character varying(6),
    faddress text,
    uncode character varying(9),
    tcode character varying(6),
    distcode character varying(3),
    procode character varying(1),
    pvh_date date,
    case_epi_no character varying(35),
    patient_name character varying(100),
    patient_gender character varying(1),
    patient_fathername character varying(100),
    patient_dob date,
    age_months integer DEFAULT 0,
    patient_address text,
    patient_address_uncode character varying(9),
    patient_address_tcode character varying(6),
    patient_address_distcode character varying(3),
    patient_address_procode character varying(1),
    date_rash_onset date,
    last_dose_date date,
    specimen_type character varying(20),
    specimen_collection_date date,
    specimen_sent_lab_date date,
    followup_date date,
    outcome character varying(20),
    epid_year character varying(4),
    case_number integer DEFAULT 0,
    dcode integer,
    complication character varying(18),
    death_date date,
    specimen_result character varying(20),
    form_completion_date date,
    week integer,
    datefrom date,
    dateto date,
    case_reported integer DEFAULT 1 NOT NULL,
    year character varying(4),
    type_specimen text,
    date_collection date,
    date_sent_lab date,
    fweek character varying(7),
    case_reported_to character varying(3),
    submitted_date date,
    editted_date date,
    date_investigation date,
    clinical_representation text,
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    doses_received integer,
    contact_numb character varying(15),
    cross_notified integer DEFAULT 0,
    cross_notified_from_distcode character varying(3),
    approval_status character varying(10),
    rb_distcode character varying(3),
    rb_tcode character varying(6),
    rb_uncode character varying(9),
    rb_facode character varying(6),
    rb_faddress text,
    notification_date date,
    complications text,
    case_type text,
    other_complication text,
    other_case_representation text,
    th_province text,
    th_district text,
    th_tehsil text,
    th_uc text,
    th_muhallah text,
    th_procode character varying(1),
    th_distcode character varying(3),
    th_tcode character varying(6),
    th_uncode character varying(9),
    th_facode character varying(6),
    travel_history integer DEFAULT 2,
    labresult_tobesentto character varying(3),
    investigator_name text,
    investigator_designation text,
    specimen_received_date date,
    specimen_condition text,
    specimen_received_by text,
    received_by_designation text,
    lab_id_number character varying(30),
    lab_testdone_date date,
    type_of_test text,
    comments text,
    lab_report_sent_date date,
    report_sent_by text,
    sent_by_designation text,
    result_saved_date date,
    other_pro_district text,
    other_pro_tehsil text,
    other_pro_uc text,
    quantity_adequate integer,
    cold_chain_ok integer,
    report_submit_status integer DEFAULT 0,
    other_specimen text,
    leakage_broken integer,
    test_possible integer,
    other_specimen_lab text,
    other_specimen_result text,
    father_nic character varying(15),
    labresult_tobesentto_district character varying,
    cn_id_from integer DEFAULT 0,
    cn_id_to integer DEFAULT 0,
    cross_case_id text,
    epidem_linked_case integer,
    linked_epid_number character varying,
    final_classification character varying,
    specimen_quantity_adequate integer,
    clinically_compatible_with character varying,
    specimen_collected integer DEFAULT 0,
    child_registration_num character varying,
    clinical_competible character varying,
    lab_final_classification character varying(30)
);

COMMENT ON COLUMN case_investigation_db.is_temp_saved IS '0 means form is completely filled and saved from submit button, 1 means checklist is not completed and temporarily saved for re-edit later';


CREATE TABLE case_response_tbl (
    id integer DEFAULT nextval('case_response_id_seq'::regclass) NOT NULL,
    procode character varying(1) DEFAULT 3,
    distcode character varying(3),
    tcode character varying(6),
    uncode character varying(9),
    vcode character varying(12),
    disease text,
    date_of_activity date,
    vaccines text,
    "0_11_m_m" integer,
    "0_11_m_f" integer,
    "12_23_m_m" integer,
    "12_23_m_f" integer,
    years_m integer,
    years_f integer,
    total_m integer,
    total_f integer,
    total_m_f integer,
    blood_speciment_collected integer,
    oral_swabs_collected integer,
    follow_up_visit date,
    submitdate date,
    updatdate date,
    total_one_to_m integer,
    total_one_to_f integer,
    total_twelve_to_m integer,
    total_twelve_to_f integer,
    total_year_m integer,
    total_year_f integer,
    total_mm integer,
    total_ff integer,
    t_m_f integer,
    age_group_from integer,
    age_group_to integer,
    reported_case_base_surveillance integer,
    active_search_case integer,
    epi_linked_case integer
);


CREATE TABLE caseepidcount_master (
    pk_id integer DEFAULT nextval('caseepidcount_master_id_seq'::regclass) NOT NULL,
    procode character varying(1),
    distcode character varying(3),
    case_type text,
    dosenumber integer DEFAULT 0,
    lessthan9months integer DEFAULT 0,
    lessthan9months_samplecollected integer DEFAULT 0,
    lessthan9months_result_positive integer DEFAULT 0,
    lessthan9months_result_positive_rubella integer DEFAULT 0,
    age9to24months integer DEFAULT 0,
    age9to24months_samplecollected integer DEFAULT 0,
    age9to24months_result_positive integer DEFAULT 0,
    age9to24months_result_positive_rubella integer DEFAULT 0,
    age24to60months integer DEFAULT 0,
    age24to60months_samplecollected integer DEFAULT 0,
    age24to60months_result_positive integer DEFAULT 0,
    age24to60months_result_positive_rubella integer DEFAULT 0,
    age60to120months integer DEFAULT 0,
    age60to120months_samplecollected integer DEFAULT 0,
    age60to120months_result_positive integer DEFAULT 0,
    age60to120months_result_positive_rubella integer DEFAULT 0,
    age120to180months integer DEFAULT 0,
    age120to180months_samplecollected integer DEFAULT 0,
    age120to180months_result_positive integer DEFAULT 0,
    age120to180months_result_positive_rubella integer DEFAULT 0,
    greaterthan180months integer DEFAULT 0,
    greaterthan180months_samplecollected integer DEFAULT 0,
    greaterthan180months_result_positive integer DEFAULT 0,
    greaterthan180months_result_positive_rubella integer DEFAULT 0,
    unknown integer DEFAULT 0,
    unknown_samplecollected integer DEFAULT 0,
    unknown_result_positive integer DEFAULT 0,
    unknown_result_positive_rubella integer DEFAULT 0,
    gender text,
    dateofnotification_week integer DEFAULT 0,
    year character varying(4),
    selected_week integer DEFAULT 0
);


CREATE TABLE cc_mechanic (
    ccm_code character varying(5) NOT NULL,
    ccm_name character varying(40),
    fathername character varying(40),
    nic character varying(20),
    date_of_birth date,
    procode character varying(1) DEFAULT '2'::character varying NOT NULL,
    distcode character varying(3) NOT NULL,
    tcode character varying(8),
    facode character varying(6),
    uncode character varying(12),
    permanent_address character varying(120),
    present_address character varying(120),
    postalcode character varying(15),
    city character varying(40),
    phone character varying(20),
    area_type character varying(20),
    status character varying(15),
    marital_status character varying(15),
    lastqualification character varying(15),
    passingyear integer,
    institutename character varying(120),
    date_joining date,
    place_of_joining character varying(80),
    place_of_posting character varying(80),
    designation character varying(80),
    bankaccountno character varying(30),
    payscale character varying(10),
    bid character varying(6),
    basicpay double precision,
    husbandname character varying(50),
    date_termination date,
    date_transfer date,
    date_died date,
    date_retired date,
    c_id integer DEFAULT nextval('codb_seq'::regclass) NOT NULL,
    branchcode character varying(15),
    branchname character varying(50),
    employee_type character varying(15),
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    basic_training_start_date date,
    basic_training_end_date date,
    routine_epi_start_date date,
    routine_epi_end_date date,
    survilance_training_start_date date,
    survilance_training_end_date date,
    cold_chain_training_start_date date,
    cold_chain_training_end_date date,
    vlmis_training_start_date date,
    vlmis_training_end_date date,
    date_from date,
    date_to date
);


CREATE TABLE cc_techniciandb (
    cc_techniciancode character varying(5) NOT NULL,
    cc_technicianname character varying(40),
    fathername character varying(40),
    nic character varying(20),
    date_of_birth date,
    procode character varying(1) DEFAULT '2'::character varying NOT NULL,
    distcode character varying(3) NOT NULL,
    tcode character varying(8),
    facode character varying(6),
    uncode character varying(12),
    permanent_address character varying(120),
    present_address character varying(120),
    postalcode character varying(15),
    city character varying(40),
    phone character varying(20),
    area_type character varying(20),
    status character varying(15),
    marital_status character varying(15),
    lastqualification character varying(15),
    passingyear integer,
    institutename character varying(120),
    date_joining date,
    place_of_joining character varying(80),
    place_of_posting character varying(80),
    designation character varying(80),
    bankaccountno character varying(30),
    payscale character varying(10),
    bid character varying(6),
    basicpay double precision,
    husbandname character varying(50),
    date_termination date,
    date_transfer date,
    date_died date,
    date_retired date,
    c_id integer DEFAULT nextval('codb_seq'::regclass) NOT NULL,
    branchcode character varying(15),
    branchname character varying(50),
    employee_type character varying(15),
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    basic_training_start_date date,
    basic_training_end_date date,
    routine_epi_start_date date,
    routine_epi_end_date date,
    survilance_training_start_date date,
    survilance_training_end_date date,
    cold_chain_training_start_date date,
    cold_chain_training_end_date date,
    vlmis_training_start_date date,
    vlmis_training_end_date date,
    previous_table text,
    previous_code integer,
    date_from date,
    date_to date
);



CREATE TABLE ccald_db (
    ccald_c1 text,
    ccald_c2 text,
    ccald_c3 text,
    ccald_c4 text,
    ccald_c5 text,
    ccald_c6 text,
    ccald_c7 text,
    ccald_c8 text,
    ccald_c9 text,
    ccald_c10 text,
    ccald_c11 text,
    ccald_c12 text,
    ccald_c13 text,
    ccald_c14 text,
    ccald_c15 text,
    ccald_c16 text,
    ccald_c17 text,
    ccald_c18 text,
    ccald_c19 text,
    ccald_c20 text,
    ccald_c21 text,
    ccald_c22 text,
    ccald_c23 text,
    ccald_c24 text,
    ccald_c25 text,
    ccald_c26 text,
    ccald_c27 text,
    ccald_c28 text,
    ccald_c29 text,
    ccald_c30 text,
    ccald_c31 text,
    ccald_c32 text,
    ccald_c33 text,
    ccald_c34 text,
    ccald_c35 text,
    ccald_c36 text,
    ccald_c37 text,
    ccald_c38 text
);




CREATE TABLE ccddb (
    ccdcode character varying(7) NOT NULL,
    ccdname character varying(40) NOT NULL,
    fathername character varying(40),
    nic character varying(15),
    date_of_birth date,
    procode character varying(1) NOT NULL,
    distcode character varying(3) NOT NULL,
    facode character varying(6),
    tcode character varying(6),
    uncode character varying(9),
    catch_area_pop integer,
    catch_area_name character varying(60),
    permanent_address character varying(120),
    present_address character varying(120),
    lastqualification character varying(15),
    passingyear integer,
    institutename character varying(120),
    date_joining date,
    place_of_joining character varying(30),
    date_termination date,
    status character varying(15),
    areatype character varying(6),
    basic_training_start_date date,
    basic_training_end_date date,
    routine_epi_start_date date,
    routine_epi_end_date date,
    id integer DEFAULT nextval('ccd_id_seq'::regclass) NOT NULL,
    city character varying(50),
    phone character varying(30),
    marital_status character varying(40),
    designation character varying(50),
    bankaccountno character varying(40),
    payscale character varying(30),
    bid character varying(10),
    basicpay double precision,
    date_transfer date,
    date_died date,
    date_retired date,
    survilance_training_start_date date,
    survilance_training_end_date date,
    cold_chain_training_start_date date,
    cold_chain_training_end_date date,
    vlmis_training_start_date date,
    vlmis_training_end_date date,
    rec_training_start_date date,
    rec_training_end_date date,
    branchcode character varying(15),
    branchname character varying(50),
    employee_type character varying(50)
);


CREATE TABLE ccgdb (
    ccgcode character varying(7) NOT NULL,
    ccgname character varying(40) NOT NULL,
    fathername character varying(40),
    nic character varying(15),
    date_of_birth date,
    procode character varying(1) NOT NULL,
    distcode character varying(3) NOT NULL,
    facode character varying(6),
    tcode character varying(6),
    uncode character varying(9),
    catch_area_pop integer,
    catch_area_name character varying(60),
    permanent_address character varying(120),
    present_address character varying(120),
    lastqualification character varying(15),
    passingyear integer,
    institutename character varying(120),
    date_joining date,
    place_of_joining character varying(30),
    date_termination date,
    status character varying(15),
    areatype character varying(6),
    basic_training_start_date date,
    basic_training_end_date date,
    routine_epi_start_date date,
    routine_epi_end_date date,
    id integer DEFAULT nextval('ccg_id_seq'::regclass) NOT NULL,
    city character varying(50),
    phone character varying(30),
    marital_status character varying(40),
    designation character varying(50),
    bankaccountno character varying(40),
    payscale character varying(30),
    bid character varying(10),
    basicpay double precision,
    date_transfer date,
    date_died date,
    date_retired date,
    survilance_training_start_date date,
    survilance_training_end_date date,
    cold_chain_training_start_date date,
    cold_chain_training_end_date date,
    vlmis_training_start_date date,
    vlmis_training_end_date date,
    rec_training_start_date date,
    rec_training_end_date date,
    branchcode character varying(15),
    branchname character varying(50),
    employee_type character varying(50)
);


CREATE TABLE ccmdb (
    ccmcode character varying(7) NOT NULL,
    ccmname character varying(40) NOT NULL,
    fathername character varying(40),
    nic character varying(15),
    date_of_birth date,
    procode character varying(1) NOT NULL,
    distcode character varying(3) NOT NULL,
    facode character varying(6),
    tcode character varying(6),
    uncode character varying(9),
    catch_area_pop integer,
    catch_area_name character varying(60),
    permanent_address character varying(120),
    present_address character varying(120),
    lastqualification character varying(15),
    passingyear integer,
    institutename character varying(120),
    date_joining date,
    place_of_joining character varying(30),
    date_termination date,
    status character varying(15),
    areatype character varying(6),
    basic_training_start_date date,
    basic_training_end_date date,
    routine_epi_start_date date,
    routine_epi_end_date date,
    id integer DEFAULT nextval('ccm_id_seq'::regclass) NOT NULL,
    city character varying(50),
    phone character varying(30),
    marital_status character varying(40),
    designation character varying(50),
    bankaccountno character varying(40),
    payscale character varying(30),
    bid character varying(10),
    basicpay double precision,
    date_transfer date,
    date_died date,
    date_retired date,
    survilance_training_start_date date,
    survilance_training_end_date date,
    cold_chain_training_start_date date,
    cold_chain_training_end_date date,
    vlmis_training_start_date date,
    vlmis_training_end_date date,
    rec_training_start_date date,
    rec_training_end_date date,
    branchcode character varying(15),
    branchname character varying(50),
    employee_type character varying(50),
    reason text,
    date_resigned date,
    previous_table text,
    previous_code integer
);


CREATE TABLE cco_db (
    cco_code character varying(5) NOT NULL,
    cco_name character varying(40),
    fathername character varying(40),
    nic character varying(20),
    date_of_birth date,
    procode character varying(1) DEFAULT '2'::character varying NOT NULL,
    distcode character varying(3) NOT NULL,
    tcode character varying(8),
    facode character varying(6),
    uncode character varying(12),
    permanent_address character varying(120),
    present_address character varying(120),
    postalcode character varying(15),
    city character varying(40),
    phone character varying(20),
    area_type character varying(20),
    status character varying(15),
    marital_status character varying(15),
    lastqualification character varying(15),
    passingyear integer,
    institutename character varying(120),
    date_joining date,
    place_of_joining character varying(80),
    place_of_posting character varying(80),
    designation character varying(80),
    bankaccountno character varying(30),
    payscale character varying(10),
    bid character varying(6),
    basicpay double precision,
    husbandname character varying(50),
    date_termination date,
    date_transfer date,
    date_died date,
    date_retired date,
    c_id integer DEFAULT nextval('codb_seq'::regclass) NOT NULL,
    branchcode character varying(15),
    branchname character varying(50),
    employee_type character varying(15),
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    basic_training_start_date date,
    basic_training_end_date date,
    routine_epi_start_date date,
    routine_epi_end_date date,
    survilance_training_start_date date,
    survilance_training_end_date date,
    cold_chain_training_start_date date,
    cold_chain_training_end_date date,
    vlmis_training_start_date date,
    vlmis_training_end_date date,
    reason date,
    date_resigned date,
    previous_table text,
    previous_code integer,
    date_from date,
    date_to date
);


CREATE TABLE ccoperatordb (
    ccoperatorname character varying(40),
    fathername character varying(40),
    nic character varying(20),
    date_of_birth date,
    procode character varying(1) DEFAULT '2'::character varying NOT NULL,
    distcode character varying(3) NOT NULL,
    tcode character varying(8),
    facode character varying(6),
    uncode character varying(12),
    permanent_address character varying(120),
    present_address character varying(120),
    postalcode character varying(15),
    city character varying(40),
    phone character varying(20),
    area_type character varying(20),
    status character varying(15),
    marital_status character varying(15),
    lastqualification character varying(15),
    passingyear integer,
    institutename character varying(120),
    date_joining date,
    place_of_joining character varying(80),
    place_of_posting character varying(80),
    designation character varying(80),
    bankaccountno character varying(30),
    payscale character varying(10),
    bid character varying(6),
    basicpay double precision,
    husbandname character varying(50),
    date_termination date,
    date_transfer date,
    date_died date,
    date_retired date,
    c_id integer DEFAULT nextval('ccoperatordb_id_seq'::regclass) NOT NULL,
    branchcode character varying(15),
    branchname character varying(15),
    employee_type character varying(15)
);


CREATE TABLE cctdb (
    cctcode character varying(7) NOT NULL,
    cctname character varying(40) NOT NULL,
    fathername character varying(40),
    nic character varying(15),
    date_of_birth date,
    procode character varying(1) NOT NULL,
    distcode character varying(3) NOT NULL,
    facode character varying(6),
    tcode character varying(6),
    uncode character varying(9),
    catch_area_pop integer,
    catch_area_name character varying(60),
    permanent_address character varying(120),
    present_address character varying(120),
    lastqualification character varying(15),
    passingyear integer,
    institutename character varying(120),
    date_joining date,
    place_of_joining character varying(30),
    date_termination date,
    status character varying(15),
    areatype character varying(6),
    basic_training_start_date date,
    basic_training_end_date date,
    routine_epi_start_date date,
    routine_epi_end_date date,
    id integer DEFAULT nextval('cct_id_seq'::regclass) NOT NULL,
    city character varying(50),
    phone character varying(30),
    marital_status character varying(40),
    designation character varying(50),
    bankaccountno character varying(40),
    payscale character varying(30),
    bid character varying(10),
    basicpay double precision,
    date_transfer date,
    date_died date,
    date_retired date,
    survilance_training_start_date date,
    survilance_training_end_date date,
    cold_chain_training_start_date date,
    cold_chain_training_end_date date,
    vlmis_training_start_date date,
    vlmis_training_end_date date,
    epimis_training_start_date date,
    epimis_training_end_date date,
    branchcode character varying(15),
    branchname character varying(50),
    employee_type character varying(50),
    reason text,
    date_resigned date
);


CREATE TABLE cerv_child_registration (
    recno integer DEFAULT nextval('child_registration_seq'::regclass) NOT NULL,
    child_registration_no character varying(30) NOT NULL,
    cardno character varying(10) NOT NULL,
    techniciancode character varying(9) NOT NULL,
    procode character varying(1) NOT NULL,
    distcode character varying(3) NOT NULL,
    tcode character varying(6) NOT NULL,
    uncode character varying(9) NOT NULL,
    reg_facode character varying(6) NOT NULL,
    imei character varying(50),
    nameofchild character varying(50),
    gender character varying(1) NOT NULL,
    dateofbirth date NOT NULL,
    fathername character varying(50) DEFAULT NULL::character varying,
    fathercnic character varying(15) DEFAULT NULL::character varying,
    contactno character varying(20) DEFAULT NULL::character varying,
    latitude character varying(30) DEFAULT NULL::character varying,
    longitude character varying(30) DEFAULT NULL::character varying,
    bcg date,
    hepb date,
    opv0 date,
    opv1 date,
    opv2 date,
    opv3 date,
    penta1 date,
    penta2 date,
    penta3 date,
    pcv1 date,
    pcv2 date,
    pcv3 date,
    ipv date,
    rota1 date,
    rota2 date,
    measles1 date,
    measles2 date,
    submitteddate date DEFAULT now(),
    mothername character varying(50) DEFAULT NULL::character varying,
    housestreet character varying(100) DEFAULT NULL::character varying,
    villagemohallah character varying(100) DEFAULT NULL::character varying,
    bcg_lat character varying(30) DEFAULT NULL::character varying,
    bcg_long character varying(30) DEFAULT NULL::character varying,
    hepb_lat character varying(30) DEFAULT NULL::character varying,
    hepb_long character varying(30) DEFAULT NULL::character varying,
    opv0_lat character varying(30) DEFAULT NULL::character varying,
    opv0_long character varying(30) DEFAULT NULL::character varying,
    opv1_lat character varying(30) DEFAULT NULL::character varying,
    opv1_long character varying(30) DEFAULT NULL::character varying,
    opv2_lat character varying(30) DEFAULT NULL::character varying,
    opv2_long character varying(30) DEFAULT NULL::character varying,
    opv3_lat character varying(30) DEFAULT NULL::character varying,
    opv3_long character varying(30) DEFAULT NULL::character varying,
    penta1_lat character varying(30) DEFAULT NULL::character varying,
    penta1_long character varying(30) DEFAULT NULL::character varying,
    penta2_lat character varying(30) DEFAULT NULL::character varying,
    penta2_long character varying(30) DEFAULT NULL::character varying,
    penta3_lat character varying(30) DEFAULT NULL::character varying,
    penta3_long character varying(30) DEFAULT NULL::character varying,
    pcv1_lat character varying(30) DEFAULT NULL::character varying,
    pcv1_long character varying(30) DEFAULT NULL::character varying,
    pcv2_lat character varying(30) DEFAULT NULL::character varying,
    pcv2_long character varying(30) DEFAULT NULL::character varying,
    pcv3_lat character varying(30) DEFAULT NULL::character varying,
    pcv3_long character varying(30) DEFAULT NULL::character varying,
    ipv_lat character varying(30) DEFAULT NULL::character varying,
    ipv_long character varying(30) DEFAULT NULL::character varying,
    rota1_lat character varying(30) DEFAULT NULL::character varying,
    rota1_long character varying(30) DEFAULT NULL::character varying,
    rota2_lat character varying(30) DEFAULT NULL::character varying,
    rota2_long character varying(30) DEFAULT NULL::character varying,
    measles1_lat character varying(30) DEFAULT NULL::character varying,
    measles1_long character varying(30) DEFAULT NULL::character varying,
    measles2_lat character varying(30) DEFAULT NULL::character varying,
    measles2_long character varying(30) DEFAULT NULL::character varying,
    fingerprint text,
    year character varying(4) DEFAULT NULL::character varying,
    bcg_facode character varying(6) DEFAULT NULL::character varying,
    hepb_facode character varying(6) DEFAULT NULL::character varying,
    opv0_facode character varying(6) DEFAULT NULL::character varying,
    opv1_facode character varying(6) DEFAULT NULL::character varying,
    opv2_facode character varying(6) DEFAULT NULL::character varying,
    opv3_facode character varying(6) DEFAULT NULL::character varying,
    penta1_facode character varying(6) DEFAULT NULL::character varying,
    penta2_facode character varying(6) DEFAULT NULL::character varying,
    penta3_facode character varying(6) DEFAULT NULL::character varying,
    pcv1_facode character varying(6) DEFAULT NULL::character varying,
    pcv2_facode character varying(6) DEFAULT NULL::character varying,
    pcv3_facode character varying(6) DEFAULT NULL::character varying,
    ipv_facode character varying(6) DEFAULT NULL::character varying,
    rota1_facode character varying(6) DEFAULT NULL::character varying,
    rota2_facode character varying(6) DEFAULT NULL::character varying,
    measles1_facode character varying(6) DEFAULT NULL::character varying,
    measles2_facode character varying(6) DEFAULT NULL::character varying,
    issynced character varying(1) DEFAULT '0'::character varying NOT NULL,
    isoutsitefacility character varying(1) DEFAULT '0'::character varying NOT NULL,
    addeddatetime date DEFAULT now() NOT NULL,
    updatedatetime date DEFAULT now() NOT NULL,
    mothercnic character varying(15) DEFAULT NULL::character varying,
    mother_cardno character varying(17),
    bcg_mode character(1),
    hepb_mode character(1),
    opv0_mode character(1),
    opv1_mode character(1),
    opv2_mode character(1),
    opv3_mode character(1),
    penta1_mode character(1),
    penta2_mode character(1),
    penta3_mode character(1),
    pcv1_mode character(1),
    pcv2_mode character(1),
    pcv3_mode character(1),
    ipv_mode character(1),
    rota1_mode character(1),
    rota2_mode character(1),
    measles1_mode character(1),
    measles2_mode character(1),
    bcg_techniciancode character varying(9),
    hepb_techniciancode character varying(9),
    opv0_techniciancode character varying(9),
    opv1_techniciancode character varying(9),
    opv2_techniciancode character varying(9),
    opv3_techniciancode character varying(9),
    penta1_techniciancode character varying(9),
    penta2_techniciancode character varying(9),
    penta3_techniciancode character varying(9),
    pcv1_techniciancode character varying(9),
    pcv2_techniciancode character varying(9),
    pcv3_techniciancode character varying(9),
    ipv_techniciancode character varying(9),
    rota1_techniciancode character varying(9),
    rota2_techniciancode character varying(9),
    measles1_techniciancode character varying(9),
    measles2_techniciancode character varying(9),
    address_lat text,
    address_lng text,
    dateofdeath date,
    dateofrefusal date,
    address text,
    deleted_at timestamp without time zone,
    shift_in_date date,
    shift_out_date date,
    next_visit_date date,
    is_aefi_case integer DEFAULT 0
);


COMMENT ON COLUMN cerv_child_registration.deleted_at IS 'To soft delete the child record use this column and update its value to current datetime when deleting record and then update the recno column value. Other wise deleted record would not delete from the cerv app';


CREATE TABLE cerv_loginlog (
    recno bigint DEFAULT nextval('cerv_loginlog_seq'::regclass) NOT NULL,
    username character varying(20),
    attemptedresult character varying(20),
    ip character varying(20),
    imeino character varying(20),
    lat character varying(20),
    lng character varying(20),
    logindatetime date DEFAULT now(),
    reason character varying(50),
    source character varying(10),
    information text,
    activitydatetime character varying(20),
    response text
);


CREATE TABLE cerv_mother_registration (
    recno integer DEFAULT nextval('mother_registration_seq'::regclass) NOT NULL,
    cardno character varying(10) NOT NULL,
    mother_registration_no character varying(30) NOT NULL,
    techniciancode character varying(9) NOT NULL,
    imei character varying(15),
    latitude text DEFAULT NULL::character varying,
    longitude text DEFAULT NULL::character varying,
    fingerprint text,
    year character varying(10) NOT NULL,
    mother_name text NOT NULL,
    husband_name text DEFAULT NULL::character varying,
    mother_cnic character varying(15),
    contactno character varying(20) DEFAULT NULL::character varying,
    procode character varying(1) NOT NULL,
    distcode character varying(3) NOT NULL,
    tcode character varying(6) NOT NULL,
    uncode character varying(9) NOT NULL,
    village text DEFAULT NULL::character varying,
    house text DEFAULT NULL::character varying,
    is_outer_registered character varying(1) DEFAULT '0'::character varying,
    reg_facode character varying(6),
    tt1 date,
    tt1_lat text DEFAULT NULL::character varying,
    tt1_long text DEFAULT NULL::character varying,
    tt1_facode character varying(6) DEFAULT NULL::character varying,
    tt2 date,
    tt2_lat text DEFAULT NULL::character varying,
    tt2_long text DEFAULT NULL::character varying,
    tt2_facode character varying(6) DEFAULT NULL::character varying,
    tt3 date,
    tt3_lat text DEFAULT NULL::character varying,
    tt3_long text DEFAULT NULL::character varying,
    tt3_facode character varying(6) DEFAULT NULL::character varying,
    tt4 date,
    tt4_lat text DEFAULT NULL::character varying,
    tt4_long text DEFAULT NULL::character varying,
    tt4_facode character varying(6) DEFAULT NULL::character varying,
    tt5 date,
    tt5_lat text DEFAULT NULL::character varying,
    tt5_long text DEFAULT NULL::character varying,
    tt5_facode character varying(6) DEFAULT NULL::character varying,
    is_synced character varying(1) DEFAULT '0'::character varying,
    submitted_date date DEFAULT now(),
    tt1_mode character(1),
    tt2_mode character(1),
    tt3_mode character(1),
    tt4_mode character(1),
    tt5_mode character(1),
    mother_age numeric DEFAULT 0,
    tt1_techniciancode character varying(9),
    tt2_techniciancode character varying(9),
    tt3_techniciancode character varying(9),
    tt4_techniciancode character varying(9),
    tt5_techniciancode character varying(9),
    address text,
    address_lat text,
    address_lng text,
    shift_in_date date,
    shift_out_date date,
    dateofdeath date,
    dateofrefusal date,
    deleted_at timestamp without time zone,
    ipv2 date,
    ipv2_lat character varying(12),
    ipv2_long character varying(12),
    ipv2_facode character varying(6) DEFAULT NULL::character varying,
    ipv2_techniciancode character varying(9),
    ipv2_mode character(1),
    tcv date,
    tcv_lat character varying(12),
    tcv_long character varying(12),
    tcv_facode character varying(6) DEFAULT NULL::character varying,
    tcv_techniciancode character varying(9),
    tcv_mode character(1)
);


CREATE TABLE cerv_shifted_childs_history (
    id integer DEFAULT nextval('cerv_shiftout_childs_seq'::regclass) NOT NULL,
    from_child_registration_no character varying(17) NOT NULL,
    from_distcode character varying(3) NOT NULL,
    from_tcode character varying(6) NOT NULL,
    from_uncode character varying(9) NOT NULL,
    from_facode character varying(6),
    to_child_registration_no character varying(17),
    to_distcode character varying(3),
    to_tcode character varying(6),
    to_uncode character varying(9),
    to_facode character varying(6),
    shiftedout_date timestamp without time zone NOT NULL,
    shiftedin_date timestamp without time zone,
    status integer DEFAULT 0
);


CREATE TABLE cerv_support (
    pk_id integer NOT NULL,
    cerv_registration_no character varying(30),
    pwd character varying(15),
    pn_token text,
    imei_no character varying(30)
);


CREATE TABLE cerv_villages (
    id integer DEFAULT nextval('cerv_village_id_seq'::regclass) NOT NULL,
    procode character varying(1) NOT NULL,
    distcode character varying(3) NOT NULL,
    tcode character varying(6) NOT NULL,
    uncode character varying(9) NOT NULL,
    vcode character varying(12) NOT NULL,
    village text NOT NULL,
    population character varying(6),
    updated_date date,
    added_date date DEFAULT now() NOT NULL,
    facode character varying(6),
    postal_address text,
    techniciancode character varying(9),
    year character varying(4)
);


CREATE TABLE childhood_tb_outbreak_linelist (
    id integer DEFAULT nextval('childhood_tb_outbreak_linelist_id_seq'::regclass) NOT NULL,
    village_mahalla character varying(50),
    distcode character varying(3),
    date_investigation date,
    uncode character varying(9),
    tcode character varying(6),
    procode character varying(1),
    investigation_by character varying(50),
    fname_father character varying(100),
    case_epi_no character varying(26),
    age_in_months integer,
    gender character varying(6),
    child_address character varying(255),
    vacc_dose_no integer,
    date_last_dose date,
    date_rash_onset date,
    date_collection_blood date,
    date_collection_throat date,
    date_follow_up date,
    date_death date,
    complication character varying(100),
    linelist_group integer DEFAULT 0,
    date_submitted date
);


CREATE TABLE codb (
    cocode character varying(5) NOT NULL,
    coname character varying(40),
    fathername character varying(40),
    nic character varying(20),
    date_of_birth date,
    procode character varying(1) DEFAULT '2'::character varying NOT NULL,
    distcode character varying(3) NOT NULL,
    tcode character varying(8),
    facode character varying(6),
    uncode character varying(12),
    permanent_address character varying(120),
    present_address character varying(120),
    postalcode character varying(15),
    city character varying(40),
    phone character varying(20),
    area_type character varying(20),
    status character varying(15),
    marital_status character varying(15),
    lastqualification character varying(15),
    passingyear integer,
    institutename character varying(120),
    date_joining date,
    place_of_joining character varying(80),
    place_of_posting character varying(80),
    designation character varying(80),
    bankaccountno character varying(30),
    payscale character varying(10),
    bid character varying(6),
    basicpay double precision,
    husbandname character varying(50),
    date_termination date,
    date_transfer date,
    date_died date,
    date_retired date,
    c_id integer DEFAULT nextval('codb_seq'::regclass) NOT NULL,
    branchcode character varying(15),
    branchname character varying(50),
    employee_type character varying(15),
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    basic_training_start_date date,
    basic_training_end_date date,
    routine_epi_start_date date,
    routine_epi_end_date date,
    survilance_training_start_date date,
    survilance_training_end_date date,
    cold_chain_training_start_date date,
    cold_chain_training_end_date date,
    vlmis_training_start_date date,
    vlmis_training_end_date date,
    previouse_code character varying(9),
    date_resigned date,
    reason text,
    previous_table text,
    previous_code integer,
    date_from date,
    date_to date
);


COMMENT ON COLUMN codb.is_temp_saved IS '0 means form is completely filled and saved from submit button, 1 means checklist is not completed and temporarily saved for re-edit later';


CREATE TABLE consumptioncompliance (
    id integer DEFAULT nextval('consumptioncompliance_id_seq'::regclass) NOT NULL,
    duem1 integer DEFAULT 0,
    duem2 integer DEFAULT 0,
    duem3 integer DEFAULT 0,
    duem4 integer DEFAULT 0,
    duem5 integer DEFAULT 0,
    duem6 integer DEFAULT 0,
    duem7 integer DEFAULT 0,
    duem8 integer DEFAULT 0,
    duem9 integer DEFAULT 0,
    duem10 integer DEFAULT 0,
    duem11 integer DEFAULT 0,
    duem12 integer DEFAULT 0,
    subm1 integer DEFAULT 0,
    subm2 integer DEFAULT 0,
    subm3 integer DEFAULT 0,
    subm4 integer DEFAULT 0,
    subm5 integer DEFAULT 0,
    subm6 integer DEFAULT 0,
    subm7 integer DEFAULT 0,
    subm8 integer DEFAULT 0,
    subm9 integer DEFAULT 0,
    subm10 integer DEFAULT 0,
    subm11 integer DEFAULT 0,
    subm12 integer DEFAULT 0,
    year character varying(4) DEFAULT 0,
    distcode character varying(3) DEFAULT 0,
    procode character varying(1) DEFAULT 3 NOT NULL,
    tsubm1 integer DEFAULT 0,
    tsubm2 integer DEFAULT 0,
    tsubm3 integer DEFAULT 0,
    tsubm4 integer DEFAULT 0,
    tsubm5 integer DEFAULT 0,
    tsubm6 integer DEFAULT 0,
    tsubm7 integer DEFAULT 0,
    tsubm8 integer DEFAULT 0,
    tsubm9 integer DEFAULT 0,
    tsubm10 integer DEFAULT 0,
    tsubm11 integer DEFAULT 0,
    tsubm12 integer DEFAULT 0,
    flag integer DEFAULT 0
);


CREATE TABLE corona_case_investigation_form_db (
    id integer NOT NULL,
    week integer NOT NULL,
    fweek character varying(7) NOT NULL,
    date_submitted date DEFAULT now() NOT NULL,
    name text,
    age_in_year integer,
    gender integer,
    occupation text,
    nationality text,
    procode character varying(1),
    distcode character varying(3),
    tcode character varying(6),
    uncode character varying(9),
    village_muhallah text,
    country text,
    city_state text,
    telephone text,
    mobile text,
    have_travel_history integer,
    have_travel_abroad integer,
    have_travel_within_country integer,
    country_1 integer,
    country_2 integer,
    country_3 integer,
    country_4 integer,
    country_5 integer,
    country_6 integer,
    country_7 integer,
    country_8 integer,
    country_9 integer,
    country_10 integer,
    country_11 integer,
    country_12 integer,
    visit_purpose text,
    stay_duration text,
    address_during_stay text,
    influenza_vaccine integer,
    know_any_person_with_symptons integer,
    date_of_onset date,
    date_of_investigation date,
    date_of_quarantine date,
    date_of_notification date,
    date_reported date,
    is_fever integer,
    is_cough integer,
    difficulty_breathing integer,
    chronic_ailment integer,
    chronic_ailment_desc text,
    any_other text,
    temprature integer,
    bp_from integer,
    bp_to integer,
    pulse_rate double precision,
    chest_asculation integer,
    retained_at_poe integer,
    no_of_days_retained integer,
    shifted_for_isolation integer,
    days_admitted integer,
    sample_collected integer,
    date_of_collection date,
    sample_type text,
    date_of_shipment_to_nih date,
    interviewer_date date,
    poe text,
    interviewer_name text,
    interviewer_designation text,
    interviewer_contact text,
    year character varying(4) NOT NULL,
    case_number integer,
    case_epi_no text,
    cross_notified integer DEFAULT 0,
    cross_notified_from_distcode character varying(3),
    approval_status character varying(10),
    rb_procode character varying(3),
    rb_distcode character varying(3),
    rb_tcode character varying(6),
    rb_uncode character varying(9),
    rb_facode character varying(6),
    rb_faddress text,
    result character varying(20),
    cn_id_from integer DEFAULT 0,
    cn_id_to integer DEFAULT 0,
    cross_case_id text,
    patient_address_procode character varying(1),
    patient_address_distcode character varying(3),
    patient_address_tcode character varying(6),
    patient_address_uncode character varying(9),
    patient_address text,
    test_result character varying(15),
    outcome character varying(20),
    date_of_death date,
    case_type text,
    facode character varying(6),
    faddress text,
    datefrom date,
    dateto date,
    pvh_date date,
    dcode character varying(3),
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    submitted_date date,
    editted_date date,
    case_reported integer DEFAULT 1 NOT NULL,
    cnic character varying(15),
    fathername text
);


CREATE TABLE country (
    pk_id integer DEFAULT nextval('country_code_seq'::regclass) NOT NULL,
    country_code character varying(5),
    country_name text
);


CREATE TABLE country_visits (
    pk_id integer NOT NULL,
    case_id integer NOT NULL,
    from_procode character varying(1),
    from_distcode character varying(3),
    from_tcode character varying(6),
    from_uncode character varying(9),
    from_address text,
    to_procode character varying(1),
    to_distcode character varying(3),
    to_tcode character varying(6),
    to_uncode character varying(9),
    to_address text,
    date_from date,
    date_to date,
    cn_id_from integer DEFAULT 0,
    cn_id_to integer DEFAULT 0,
    cross_case_id text
);


CREATE TABLE custom_filters (
    pk_id integer NOT NULL,
    title character varying(200) NOT NULL,
    name character varying(50) NOT NULL,
    type character varying(20) NOT NULL,
    id character varying(50),
    class character varying(50),
    active integer DEFAULT 1 NOT NULL,
    db integer,
    custom integer,
    value_column character varying(50),
    text_column character varying(50),
    level2_enabled integer,
    level3_enabled integer,
    query_part character varying(30),
    grouped_filter integer DEFAULT 0,
    qp_columnname text,
    wc_type character varying(30),
    other_attr text,
    formula_filter integer DEFAULT 0
);


COMMENT ON TABLE custom_filters IS 'All Filters with main definition will be listed in this table..';


CREATE TABLE custom_filters_detail (
    pk_id integer NOT NULL,
    main_filter_id integer NOT NULL,
    db_table character varying(150),
    db_columns text,
    "order" character varying(255),
    select_value character varying(100),
    select_text character varying(100),
    level2_enabled integer,
    level3_enabled integer,
    level2wc_column character varying(50),
    level2wc_value_isvariable integer,
    level2wc_value character varying(200),
    level3wc_column character varying(50),
    level3wc_value_isvariable integer,
    level3wc_value character varying(200),
    grouped_filter integer DEFAULT 0,
    groupby_column character varying(30),
    multiseries integer DEFAULT 0
);

COMMENT ON TABLE custom_filters_detail IS 'All filters definitions (if db filters) and their values and text are stored here';

COMMENT ON COLUMN custom_filters_detail.multiseries IS '0 for single series 1 for multiseries';

CREATE TABLE custom_indicators_defination (
    pk_id integer NOT NULL,
    name character varying(150) NOT NULL,
    description text,
    module_id integer NOT NULL,
    active integer DEFAULT 1 NOT NULL,
    "order" integer NOT NULL
);

COMMENT ON TABLE custom_indicators_defination IS 'All Custom indicators for epimis will be setup here..';


CREATE TABLE dashboard_widget_detail (
    pk_id integer DEFAULT nextval('dashboard_widget_detail_seqid'::regclass) NOT NULL,
    widget_title character varying(255) NOT NULL,
    module_id integer NOT NULL,
    widget_type_id integer NOT NULL,
    indicator_id integer NOT NULL,
    sub_indicator_id integer,
    created_datetime timestamp without time zone DEFAULT now() NOT NULL,
    dashboard_id integer NOT NULL,
    "user" character varying(255) NOT NULL
);


COMMENT ON TABLE dashboard_widget_detail IS 'New Widget detail in a dashboard will be stored here';


CREATE TABLE dashboardhide (
    pk_id integer DEFAULT nextval('dashboardhide_sequence_id'::regclass) NOT NULL,
    dashboardinfo_id integer,
    is_hide integer,
    username character varying(50) NOT NULL,
    hide_datetime timestamp without time zone DEFAULT now()
);



CREATE TABLE dashboardinfo (
    pk_id integer DEFAULT nextval('dashboardinfo_seq'::regclass) NOT NULL,
    name character varying(255) NOT NULL,
    access_type integer NOT NULL,
    "user" character varying(255) NOT NULL,
    created_datetime timestamp without time zone DEFAULT now() NOT NULL,
    active integer DEFAULT 1 NOT NULL
);

COMMENT ON TABLE dashboardinfo IS 'All dashboards created by users will be stored here';


CREATE TABLE data_maping (
    pk_id integer DEFAULT nextval('data_maping_seq'::regclass) NOT NULL,
    oldcode character varying(11) DEFAULT 0,
    oldtable character varying(50) DEFAULT 0,
    newcode character varying(11) DEFAULT 0
);


CREATE TABLE delete_epi_stock_batch (
    pk_id integer NOT NULL,
    number character varying(100),
    batch_master_id integer,
    expiry_date date,
    quantity integer DEFAULT 0 NOT NULL,
    status character varying(20) DEFAULT 'Stacked'::character varying NOT NULL,
    unit_price double precision NOT NULL,
    production_date date,
    last_update timestamp without time zone,
    item_pack_size_id integer,
    vvm_type_id integer,
    stakeholder_id integer,
    warehouse_type_id integer,
    code character varying(100),
    created_by text NOT NULL,
    created_date timestamp without time zone,
    ccm_id integer,
    non_ccm_id integer,
    parent_pk_id integer
);


CREATE TABLE delete_epi_stock_detail (
    pk_id integer NOT NULL,
    quantity integer NOT NULL,
    temporary integer DEFAULT 0,
    vvm_stage character varying(100),
    is_received integer,
    adjustment_type integer,
    stock_master_id integer NOT NULL,
    stock_batch_id integer NOT NULL,
    item_unit_id integer NOT NULL,
    created_by text NOT NULL,
    created_date timestamp without time zone,
    rec_adjustment integer DEFAULT 0
);


CREATE TABLE delete_epi_stock_master (
    pk_id integer NOT NULL,
    transaction_date timestamp without time zone,
    transaction_number character varying(100),
    transaction_counter integer,
    transaction_reference character varying(100),
    draft smallint DEFAULT 1 NOT NULL,
    comments text,
    transaction_type_id integer NOT NULL,
    from_warehouse_type_id integer NOT NULL,
    from_warehouse_code character varying(100),
    to_warehouse_type_id integer NOT NULL,
    to_warehouse_code character varying(100),
    parent_id integer,
    campaign_id integer,
    stakeholder_activity_id integer NOT NULL,
    created_by text NOT NULL,
    created_date timestamp without time zone,
    updated_date timestamp without time zone
);



CREATE TABLE deodb (
    deocode character varying(7) NOT NULL,
    deoname character varying(40),
    fathername character varying(40),
    nic character varying(20),
    date_of_birth date,
    procode character varying(1) DEFAULT '2'::character varying NOT NULL,
    distcode character varying(3) NOT NULL,
    tcode character varying(8),
    facode character varying(6),
    uncode character varying(12),
    permanent_address character varying(120),
    present_address character varying(120),
    postalcode character varying(15),
    city character varying(40),
    phone character varying(20),
    area_type character varying(20),
    status character varying(15),
    marital_status character varying(15),
    lastqualification character varying(15),
    passingyear integer,
    institutename character varying(120),
    date_joining date,
    place_of_joining character varying(80),
    place_of_posting character varying(80),
    designation character varying(80),
    bankaccountno character varying(30),
    payscale character varying(10),
    bid character varying(6),
    basicpay double precision,
    husbandname character varying(50),
    date_termination date,
    date_transfer date,
    date_died date,
    date_retired date,
    deo_id integer DEFAULT nextval('deodb_seq'::regclass) NOT NULL,
    branchcode character varying(15),
    branchname character varying(50),
    employee_type character varying(15),
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    previous_code character varying(9),
    current_status text
);


CREATE TABLE diphtheria_case_response (
    id integer DEFAULT nextval('diphtheria_case_response_id_seq'::regclass) NOT NULL,
    uncode character varying(9),
    procode character varying(1) DEFAULT 3,
    distcode character varying(3),
    tcode character varying(6),
    village character varying(50),
    date_of_activity date,
    reported_case_surveillance integer,
    active_search_cases integer,
    epi_linked_cases integer,
    opv_0 integer,
    pcv_10_p1 integer,
    pcv_10_p2 integer,
    pcv_10_p3 integer,
    ipv integer,
    td_dtap_dt integer,
    dip_booster_dose integer,
    age_group_selected_response integer,
    oral_swabs_collected integer,
    follow_up_visit date,
    submitdate date,
    updatdate date
);


CREATE TABLE diphtheria_outbreak_linelist (
    id integer DEFAULT nextval('diphtheria_outbreak_linelist_id_seq'::regclass) NOT NULL,
    village_mahalla character varying(50),
    distcode character varying(3),
    date_investigation date,
    uncode character varying(9),
    tcode character varying(6),
    procode character varying(1),
    investigation_by character varying(50),
    fname_father character varying(100),
    case_epi_no character varying(26),
    age_in_months integer,
    gender character varying(6),
    child_address character varying(255),
    vacc_dose_no integer,
    date_last_dose date,
    date_rash_onset date,
    date_collection_blood date,
    date_collection_throat date,
    date_follow_up date,
    date_death date,
    complication character varying(100),
    linelist_group integer DEFAULT 0,
    date_submitted date
);

CREATE TABLE diseases_surveillance_mob (
    recid integer DEFAULT nextval('idsrs_mob_wvpd_recid_seq'::regclass) NOT NULL,
    imei character varying(15) NOT NULL,
    year character varying(4) NOT NULL,
    epi_week integer NOT NULL,
    date_from date,
    date_to date,
    name_case text NOT NULL,
    gender text,
    case_age text,
    case_father_name text,
    case_father_nic character varying(15),
    case_cell character varying(20),
    case_address text,
    case_distcode character varying(3) DEFAULT 0,
    case_tcode character varying(6) DEFAULT 0,
    case_uncode character varying(9),
    case_type text NOT NULL,
    full_epid_no text,
    epid_number integer,
    case_date_onset date,
    case_date_investigation date,
    case_tot_vacc_received text,
    case_date_last_dose_received date,
    case_date_specieman date,
    specieman_result text,
    case_date_follow date,
    complication_follow text,
    complication_date date,
    death_follow text,
    death_date_follow date,
    case_type_speceicman text,
    dist_shortcode character varying(3),
    case_shortcode text,
    case_representation integer,
    other_case_representation text,
    submitted_date date,
    distcode character varying(3) NOT NULL,
    facode character varying(6),
    tcode character varying(6) NOT NULL,
    uncode character varying(9) NOT NULL,
    fweek character varying(7)
);


CREATE TABLE district_freeze (
    fr_id integer DEFAULT nextval('district_freeze_seq'::regclass) NOT NULL,
    distcode character varying NOT NULL,
    fmonth character varying NOT NULL
);



CREATE TABLE districts (
    distid integer DEFAULT nextval('districts_distid_seq'::regclass) NOT NULL,
    district character varying(100),
    province character varying(25),
    distcode character varying(3),
    population character varying(10),
    addedby integer DEFAULT 0,
    addeddate date,
    updateddate date,
    batch_status character varying(2) DEFAULT 0,
    sync_status integer DEFAULT 0,
    update_status integer DEFAULT 0,
    coordinates text,
    x integer,
    y integer,
    shortname character varying(4),
    epid_code integer,
    procode character varying(1),
    dist_type character varying(2),
    dist_order integer,
    highchart_coordinates text
);



CREATE TABLE districts_population (
    id integer DEFAULT nextval('districts_population_id_seq'::regclass) NOT NULL,
    distcode character varying(3),
    year character varying(4),
    population integer,
    created_date date,
    update_date date,
    update_by text,
    procode character varying(1) DEFAULT 3 NOT NULL
);



CREATE TABLE districts_wise_maps_paths (
    id integer DEFAULT nextval('districts_wise_maps_paths_id_seq'::regclass) NOT NULL,
    procode character varying(1) NOT NULL,
    distcode character varying(3) NOT NULL,
    district text NOT NULL,
    path text NOT NULL
);


COMMENT ON TABLE districts_wise_maps_paths IS 'table contains information about all districts and their map data which will use to draw their map boundries';

CREATE TABLE driverdb (
    drivercode character varying(7) NOT NULL,
    drivername character varying(40) NOT NULL,
    fathername character varying(40),
    nic character varying(20),
    date_of_birth date,
    procode character varying(1) NOT NULL,
    distcode character varying(3) NOT NULL,
    facode character varying(6),
    supervisorcode character varying(9),
    tcode character varying(8),
    uncode character varying(12),
    permanent_address character varying(120),
    present_address character varying(120),
    lastqualification character varying(15),
    passingyear integer,
    institutename character varying(120),
    date_joining date,
    place_of_joining character varying(80),
    date_termination date,
    status character varying(15),
    branchname character varying(80),
    bankaccount character varying(30),
    payscale character varying(10),
    officer_type character varying(15),
    bid character varying(6),
    allowances character varying(120),
    marital_status character varying(80),
    phone character varying(30),
    basicpay double precision,
    house_rent_allowance double precision,
    convence_allowance double precision,
    medical_allowance double precision,
    deductions character varying(50) DEFAULT 0,
    d_id integer DEFAULT nextval('driverid_seq'::regclass) NOT NULL,
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    branchcode character varying(15),
    basic_training_start_date date,
    basic_training_end_date date,
    routine_epi_start_date date,
    routine_epi_end_date date,
    survilance_training_start_date date,
    survilance_training_end_date date,
    cold_chain_training_start_date date,
    cold_chain_training_end_date date,
    vlmis_training_start_date date,
    vlmis_training_end_date date,
    reason date,
    date_resigned date
);


COMMENT ON COLUMN driverdb.is_temp_saved IS '0 means form is completely filled and saved from submit button, 1 means checklist is not completed and temporarily saved for re-edit later';


CREATE TABLE dsodb (
    dsocode character varying(6) NOT NULL,
    dsoname character varying(40) NOT NULL,
    fathername character varying(40),
    nic character varying(15),
    date_of_birth date,
    procode character varying(1) NOT NULL,
    distcode character varying(3) NOT NULL,
    facode character varying(6),
    tcode character varying(8),
    uncode character varying(12),
    catch_area_pop integer,
    catch_area_name character varying(60),
    permanent_address character varying(120),
    present_address character varying(120),
    lastqualification character varying(15),
    passingyear integer,
    institutename character varying(120),
    date_joining date,
    place_of_joining character varying(30),
    date_termination date,
    status character varying(15),
    areatype character varying(6),
    basic_training_start_date date,
    basic_training_end_date date,
    routine_epi_start_date date,
    routine_epi_end_date date,
    id integer DEFAULT nextval('dso_id_seq'::regclass) NOT NULL,
    city character varying(50),
    phone character varying(14),
    marital_status character varying(40),
    designation character varying(50),
    bankaccountno character varying(40),
    payscale character varying(30),
    bid character varying(10),
    basicpay double precision,
    date_transfer date,
    date_died date,
    date_retired date,
    survilance_training_start_date date,
    survilance_training_end_date date,
    cold_chain_training_start_date date,
    cold_chain_training_end_date date,
    vlmis_training_start_date date,
    vlmis_training_end_date date,
    rec_training_start_date date,
    rec_training_end_date date,
    branchcode character varying(15),
    branchname character varying(50),
    employee_type character varying(50),
    epimis_training_start_date date,
    epimis_training_end_date date,
    telephone character varying(15),
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    reason text,
    date_resigned date,
    previous_table text,
    previous_code integer,
    date_from date,
    date_to date
);

COMMENT ON COLUMN dsodb.is_temp_saved IS '0 means form is completely filled and saved from submit button, 1 means checklist is not completed and temporarily saved for re-edit later';



CREATE TABLE epi_cc_asset_status_history (
    pk_id integer DEFAULT nextval('epi_cc_asset_status_history_seq_id'::regclass) NOT NULL,
    warehouse_type_id integer,
    status integer,
    reasons integer,
    utilizations integer,
    freeze_alarm integer,
    heat_alarm integer,
    total_quantity integer,
    working_quantity integer,
    comments character varying,
    date timestamp without time zone DEFAULT now(),
    ccm_id integer,
    assets_type_id integer,
    procode character varying(1),
    distcode character varying(3),
    tcode character varying(6),
    uncode character varying(9),
    facode character varying(6),
    description text,
    status_date date
);


COMMENT ON COLUMN epi_cc_asset_status_history.warehouse_type_id IS 'will insert pk_id of epi_cc_warehouse_types table';

COMMENT ON COLUMN epi_cc_asset_status_history.ccm_id IS 'will insert asset_id of epi_cc_coldchain_main table';

COMMENT ON COLUMN epi_cc_asset_status_history.assets_type_id IS 'will insert pk_id of epi_cc_asset_types table';

CREATE TABLE epi_cc_asset_types (
    pk_id integer DEFAULT nextval('epi_asset_type_seq_id'::regclass) NOT NULL,
    asset_type_name character varying(100),
    status integer,
    parent_id integer,
    ccm_equipment_type_id integer DEFAULT 0,
    created_by integer,
    created_date timestamp without time zone,
    modified_by integer,
    modified_date timestamp without time zone,
    short_name character varying(10)
);

CREATE TABLE epi_cc_coldchain_main (
    asset_id integer DEFAULT nextval('epi_coldchain_main_seq_id'::regclass) NOT NULL,
    auto_asset_id character varying(150),
    serial_no character varying(100),
    estimate_life integer,
    working_since timestamp without time zone,
    quantity integer,
    manufacturer_year character varying(4),
    status integer,
    ccm_status_history_id integer,
    ccm_sub_asset_type_id integer,
    ccm_model_id integer,
    source_id integer,
    warehouse_type_id integer,
    approved_by integer,
    approved_on timestamp without time zone,
    created_by character varying(150),
    created_date timestamp without time zone,
    procode character varying(1),
    distcode character varying(3),
    tcode character varying(6),
    uncode character varying(9),
    facode character varying(6),
    ccm_user_asset_id character varying(30),
    ccm_temperature integer,
    ccm_voltage integer,
    auto_asset_id_increment character varying(20),
    short_name character varying(150),
    storecode integer,
    asset_status character varying(15),
    parent_id integer
);

COMMENT ON COLUMN epi_cc_coldchain_main.ccm_status_history_id IS 'will insert pk_id  of epi_cc_asset_status_history table';

COMMENT ON COLUMN epi_cc_coldchain_main.ccm_sub_asset_type_id IS 'will insert pk_id of epi_cc_asset_types table';

CREATE TABLE epi_cc_equipment_types (
    pk_id integer DEFAULT nextval('equipment_type_seq_id'::regclass) NOT NULL,
    equipment_type_name character varying(50) NOT NULL,
    status integer,
    created_by character varying(50) DEFAULT 'kpk_manager'::character varying,
    created_date timestamp without time zone DEFAULT now() NOT NULL,
    modified_by character varying(50),
    modified_date timestamp without time zone
);


ALTER TABLE public.epi_cc_equipment_types OWNER TO postgres;

--
-- Name: epi_cc_make_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epi_cc_make_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.epi_cc_make_seq OWNER TO postgres;

--
-- Name: epi_cc_makes; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_cc_makes (
    pk_id integer DEFAULT nextval('epi_cc_make_seq'::regclass) NOT NULL,
    make_name text,
    status character(1) DEFAULT 1,
    created_by character varying(30) DEFAULT 'kpk_manager'::character varying,
    created_date timestamp without time zone DEFAULT now(),
    modified_by character varying(30),
    modified_date timestamp without time zone
);


ALTER TABLE public.epi_cc_makes OWNER TO postgres;

--
-- Name: epi_cc_models; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_cc_models (
    pk_id integer DEFAULT nextval('asset_type_model_seq'::regclass) NOT NULL,
    model_name text,
    status character(1) DEFAULT 1,
    temprature_type text,
    ccm_make_id integer,
    ccm_sub_asset_type_id integer,
    created_by character varying(30) DEFAULT 'kpk_manager'::character varying,
    created_date timestamp without time zone DEFAULT now(),
    modified_by character varying(30),
    modified_date timestamp without time zone,
    asset_dimension_length double precision,
    asset_dimension_width double precision,
    asset_dimension_height double precision,
    internal_dimension_length double precision,
    internal_dimension_width double precision,
    internal_dimension_height double precision,
    storage_dimension_length double precision,
    storage_dimension_width double precision,
    storage_dimension_height double precision,
    gross_capacity_20 double precision,
    gross_capacity_4 double precision,
    net_capacity_20 double precision,
    net_capacity_4 double precision,
    cfc_free integer,
    no_of_phases integer,
    is_pqs integer,
    product_price double precision,
    gas_type character varying(15),
    power_source character varying(20),
    catalogue_id character varying(50),
    cold_life character varying(50),
    asset_type_id integer,
    utilizations integer,
    reasons integer,
    nominal_voltage text,
    continous_power text,
    frequency text,
    input_voltage_range character varying(15),
    output_voltage_range character varying(15),
    procode character varying(1),
    is_active integer DEFAULT 0
);


ALTER TABLE public.epi_cc_models OWNER TO postgres;

--
-- Name: COLUMN epi_cc_models.ccm_make_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN epi_cc_models.ccm_make_id IS 'will insert pk_id of epi_cc_makes table';


--
-- Name: COLUMN epi_cc_models.ccm_sub_asset_type_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN epi_cc_models.ccm_sub_asset_type_id IS 'will insert pk_id  of epi_cc_asset_types table';


--
-- Name: epi_cc_status_list; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_cc_status_list (
    pk_id integer DEFAULT nextval('epi_asset_status_list_seq_id'::regclass) NOT NULL,
    status_name text,
    status integer,
    created_by integer,
    created_date timestamp without time zone,
    modified_by integer,
    modified_date timestamp without time zone
);


ALTER TABLE public.epi_cc_status_list OWNER TO postgres;

--
-- Name: epi_cc_warehouse_seq_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epi_cc_warehouse_seq_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999
    CACHE 1;


ALTER TABLE public.epi_cc_warehouse_seq_id OWNER TO postgres;

--
-- Name: epi_cc_warehouse_types_seq_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epi_cc_warehouse_types_seq_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.epi_cc_warehouse_types_seq_id OWNER TO postgres;

--
-- Name: epi_cc_warehouse_types; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_cc_warehouse_types (
    pk_id integer DEFAULT nextval('epi_cc_warehouse_types_seq_id'::regclass) NOT NULL,
    warehouse_type_name character varying(100),
    resupply_interval integer,
    reserved_stock integer,
    usage_percentage double precision,
    list_rank integer,
    geolevel_id integer DEFAULT 0,
    created_by character varying(50),
    created_date timestamp without time zone DEFAULT now(),
    modified_by integer,
    modified_date timestamp without time zone,
    status integer DEFAULT 1
);


ALTER TABLE public.epi_cc_warehouse_types OWNER TO postgres;

--
-- Name: epi_ccm_cold_rooms; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_ccm_cold_rooms (
    pk_id integer DEFAULT nextval('epi_cc_cold_room_seq_id'::regclass) NOT NULL,
    has_voltage integer,
    ccm_sub_asset_type_id integer,
    ccm_id integer,
    temperature_recording_system integer,
    type_recording_system integer,
    refrigerator_gas_type integer,
    backup_generator integer,
    created_by character varying(150),
    created_date timestamp without time zone DEFAULT now(),
    updated_by character varying,
    updated_date timestamp without time zone,
    cooling_system integer,
    gross_capacity double precision,
    net_capacity double precision
);


ALTER TABLE public.epi_ccm_cold_rooms OWNER TO postgres;

--
-- Name: epi_ccm_generators_seq_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epi_ccm_generators_seq_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.epi_ccm_generators_seq_id OWNER TO postgres;

--
-- Name: epi_ccm_generators; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_ccm_generators (
    pk_id integer DEFAULT nextval('epi_ccm_generators_seq_id'::regclass) NOT NULL,
    power_rating character varying(20),
    automatic_start_mechanism integer,
    use_for character varying(50),
    power_source integer,
    ccm_id integer NOT NULL,
    created_by character varying(15),
    created_date date DEFAULT now(),
    modified_by character varying(15),
    modified_date date
);


ALTER TABLE public.epi_ccm_generators OWNER TO postgres;

--
-- Name: epi_ccm_vehicles_seq_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epi_ccm_vehicles_seq_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.epi_ccm_vehicles_seq_id OWNER TO postgres;

--
-- Name: epi_ccm_vehicles; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_ccm_vehicles (
    pk_id integer DEFAULT nextval('epi_ccm_vehicles_seq_id'::regclass) NOT NULL,
    registration_no character varying(50),
    used_for_epi integer,
    comments text,
    ccm_id integer,
    ccm_sub_asset_type_id integer,
    fuel_type_id integer,
    created_by character varying(20),
    created_date date DEFAULT now(),
    modified_by character varying(20),
    modified_date date,
    engine_no character varying(50),
    chases_no character varying(50)
);


ALTER TABLE public.epi_ccm_vehicles OWNER TO postgres;

--
-- Name: epi_ccm_voltage_regulators_seq_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epi_ccm_voltage_regulators_seq_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.epi_ccm_voltage_regulators_seq_id OWNER TO postgres;

--
-- Name: epi_ccm_voltage_regulators; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_ccm_voltage_regulators (
    pk_id integer DEFAULT nextval('epi_ccm_voltage_regulators_seq_id'::regclass) NOT NULL,
    nominal_voltage integer,
    continous_power integer,
    frequency character varying(50),
    input_voltage_range character varying(50),
    output_voltage_range character varying(50),
    ccm_id integer,
    created_by character varying(15),
    created_date date DEFAULT now(),
    modified_by character varying(15),
    modified_date date
);


ALTER TABLE public.epi_ccm_voltage_regulators OWNER TO postgres;

--
-- Name: epi_childreg_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epi_childreg_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999999999999
    CACHE 1
    CYCLE;


ALTER TABLE public.epi_childreg_id_seq OWNER TO postgres;

--
-- Name: epi_childreg; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_childreg (
    id integer DEFAULT nextval('epi_childreg_id_seq'::regclass) NOT NULL,
    iemi text,
    name_of_child text,
    gender integer,
    date_of_birth text,
    time_of_birth text,
    father_mother_name text,
    father_mother_cnic text NOT NULL,
    mobile_no text,
    latitude double precision,
    longitude double precision,
    picture text,
    ipv integer,
    opv0 integer,
    opv1 integer,
    opv2 integer,
    measles1 integer,
    measles2 integer,
    ipv_time text,
    opv0_time text,
    opv1_time text,
    opv2_time text,
    measles1_time text,
    measles2_time text,
    opv3 integer,
    opv3_time text,
    bcg integer,
    bcg_time text,
    hepb integer,
    hepb_time text,
    penta1 integer,
    penta1_time text,
    penta2 integer,
    penta2_time text,
    penta3 integer,
    penta3_time text,
    pcv10_1 integer,
    pcv10_1_time text,
    pcv10_2 integer,
    pcv10_2_time text,
    pcv10_3 integer,
    pcv10_3_time text,
    rota1 integer,
    rota1_time text,
    rota2 integer,
    rota2_time text
);


ALTER TABLE public.epi_childreg OWNER TO postgres;

--
-- Name: epi_coldchain_main_increment_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epi_coldchain_main_increment_id
    START WITH 1365
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999999
    CACHE 1
    CYCLE;


ALTER TABLE public.epi_coldchain_main_increment_id OWNER TO postgres;

--
-- Name: epi_coldroom_questionnaire_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epi_coldroom_questionnaire_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.epi_coldroom_questionnaire_id_seq OWNER TO postgres;

--
-- Name: epi_coldroom_questionnaire; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_coldroom_questionnaire (
    id integer DEFAULT nextval('epi_coldroom_questionnaire_id_seq'::regclass) NOT NULL,
    equip_rec text,
    rec_of text,
    procode character varying(1),
    distcode character varying(3),
    tcode character varying(6),
    uncode character varying(9),
    facode character varying(6),
    equip_code character varying(150),
    type_room integer,
    model character varying(100),
    manufacturer character varying(100),
    year_supply character varying(4),
    working_status integer,
    no_phases integer,
    voltage_stabilizer integer,
    temp_record_system integer,
    type_record_system character varying(15),
    plus_length double precision,
    plus_width double precision,
    plus_height double precision,
    minus_length double precision,
    minus_width double precision,
    minus_height double precision,
    plus_gross_volume double precision,
    minus_gross_volume double precision,
    plus_net_volume double precision,
    minus_net_volume double precision,
    no_cooling_systems integer,
    refrigerant_gas_type integer,
    backup_generator integer,
    cctl_name character varying(150),
    cctl_desg character varying(100),
    cctl_email character varying(50),
    cctl_mob character varying(30),
    cctl_date date,
    dc_name character varying(150),
    dc_desg character varying(100),
    dc_email character varying(50),
    dc_mob character varying(30),
    dc_date date,
    date_submitted date,
    year character varying(4),
    quarter character varying(4),
    fquarter character varying(8)
);


ALTER TABLE public.epi_coldroom_questionnaire OWNER TO postgres;

--
-- Name: epi_consumption_adjustment_pk_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epi_consumption_adjustment_pk_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.epi_consumption_adjustment_pk_id_seq OWNER TO postgres;

--
-- Name: epi_consumption_adjustment; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_consumption_adjustment (
    pk_id integer DEFAULT nextval('epi_consumption_adjustment_pk_id_seq'::regclass) NOT NULL,
    detail_id integer NOT NULL,
    main_id integer NOT NULL,
    item_id integer NOT NULL,
    batch_number text DEFAULT 'BB2019'::text NOT NULL,
    adjustment_type integer NOT NULL,
    adjustment_quantity_vials double precision DEFAULT 0 NOT NULL,
    adjustment_quantity_doses integer DEFAULT 0 NOT NULL,
    comments text,
    fmonth character varying(7),
    procode character varying(1),
    distcode character varying(3),
    tcode character varying(6),
    uncode character varying(9),
    facode character varying(6)
);


ALTER TABLE public.epi_consumption_adjustment OWNER TO postgres;

--
-- Name: epi_consumption_detail; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_consumption_detail (
    pk_id integer DEFAULT nextval('consumption_detail_id_seq'::regclass) NOT NULL,
    main_id integer NOT NULL,
    item_id integer NOT NULL,
    batch_number text DEFAULT 'BB2019'::text NOT NULL,
    batch_doses integer DEFAULT 1 NOT NULL,
    opening_doses integer DEFAULT 0 NOT NULL,
    received_doses integer DEFAULT 0 NOT NULL,
    used_doses integer DEFAULT 0 NOT NULL,
    used_vials double precision,
    unused_doses integer DEFAULT 0 NOT NULL,
    unused_vials double precision,
    closing_doses integer DEFAULT 0 NOT NULL,
    closing_vials double precision,
    vaccinated integer
);


ALTER TABLE public.epi_consumption_detail OWNER TO postgres;

--
-- Name: COLUMN epi_consumption_detail.main_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN epi_consumption_detail.main_id IS 'foreign key from epi_consumption_main';


--
-- Name: COLUMN epi_consumption_detail.item_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN epi_consumption_detail.item_id IS 'foreign key from epi_items';


--
-- Name: COLUMN epi_consumption_detail.batch_number; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN epi_consumption_detail.batch_number IS 'BB2019 mean batch exist before 2019';


--
-- Name: COLUMN epi_consumption_detail.opening_doses; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN epi_consumption_detail.opening_doses IS 'opening balance in doses';


--
-- Name: COLUMN epi_consumption_detail.received_doses; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN epi_consumption_detail.received_doses IS 'received stock in doses';


--
-- Name: COLUMN epi_consumption_detail.used_doses; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN epi_consumption_detail.used_doses IS 'used stock in doses';


--
-- Name: COLUMN epi_consumption_detail.used_vials; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN epi_consumption_detail.used_vials IS 'used stock in vials';


--
-- Name: COLUMN epi_consumption_detail.unused_doses; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN epi_consumption_detail.unused_doses IS 'unused stock in doses';


--
-- Name: COLUMN epi_consumption_detail.unused_vials; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN epi_consumption_detail.unused_vials IS 'unused stock in vials';


--
-- Name: COLUMN epi_consumption_detail.closing_doses; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN epi_consumption_detail.closing_doses IS 'closing stock in doses';


--
-- Name: COLUMN epi_consumption_detail.closing_vials; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN epi_consumption_detail.closing_vials IS 'closing stock in vials';


--
-- Name: COLUMN epi_consumption_detail.vaccinated; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN epi_consumption_detail.vaccinated IS 'values of children/women vaccinated with specific item or doses administered';


--
-- Name: epi_consumption_master; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_consumption_master (
    pk_id integer DEFAULT nextval('consumption_master_id_seq'::regclass) NOT NULL,
    fmonth character varying(7) NOT NULL,
    procode character varying(1) NOT NULL,
    distcode character varying(3) NOT NULL,
    tcode character varying(6) NOT NULL,
    uncode character varying(9) NOT NULL,
    facode character varying(6) NOT NULL,
    prepared_by text,
    hf_incharge text,
    created_by text,
    created_date date NOT NULL,
    updated_date date,
    is_compiled integer DEFAULT 1,
    data_source text DEFAULT 'web'::text
);


ALTER TABLE public.epi_consumption_master OWNER TO postgres;

--
-- Name: COLUMN epi_consumption_master.prepared_by; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN epi_consumption_master.prepared_by IS 'name of person who prepared this report ';


--
-- Name: COLUMN epi_consumption_master.hf_incharge; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN epi_consumption_master.hf_incharge IS 'hf incharge name/id from med_techniciandb table';


--
-- Name: COLUMN epi_consumption_master.created_by; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN epi_consumption_master.created_by IS 'username of loggedin user';


--
-- Name: COLUMN epi_consumption_master.created_date; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN epi_consumption_master.created_date IS 'date when this record created';


--
-- Name: COLUMN epi_consumption_master.updated_date; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN epi_consumption_master.updated_date IS 'date when this record updated last time';


--
-- Name: epi_fmonths; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_fmonths (
    id integer NOT NULL,
    shortname character varying(3) NOT NULL,
    fullname text,
    enddate character varying(2) NOT NULL
);


ALTER TABLE public.epi_fmonths OWNER TO postgres;

--
-- Name: epi_funding_source_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epi_funding_source_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.epi_funding_source_seq OWNER TO postgres;

--
-- Name: epi_funding_source; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_funding_source (
    id integer DEFAULT nextval('epi_funding_source_seq'::regclass) NOT NULL,
    name character varying(50)
);


ALTER TABLE public.epi_funding_source OWNER TO postgres;

--
-- Name: epi_generator_questionnaire_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epi_generator_questionnaire_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.epi_generator_questionnaire_id_seq OWNER TO postgres;

--
-- Name: epi_generator_questionnaire; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_generator_questionnaire (
    id integer DEFAULT nextval('epi_generator_questionnaire_id_seq'::regclass) NOT NULL,
    equip_rec text,
    rec_of text,
    procode character varying(1),
    distcode character varying(3),
    tcode character varying(6),
    uncode character varying(9),
    facode character varying(6),
    equip_code character varying(150),
    model character varying(100),
    manufacturer character varying(100),
    serial_number character varying(150),
    no_phases integer,
    power_rating double precision,
    power_source integer,
    auto_start_mechanism integer,
    used_for character varying(9),
    year_supply character varying(4),
    source_supply integer,
    working_status integer,
    equip_utilization integer,
    pr_name character varying(150),
    pr_desg character varying(100),
    pr_mob character varying(30),
    pr_email character varying(50),
    cctl_name character varying(150),
    cctl_desg character varying(100),
    cctl_mob character varying(30),
    cctl_email character varying(50),
    dc_name character varying(150),
    dc_desg character varying(100),
    dc_email character varying(50),
    dc_mob character varying(30),
    dc_date date,
    date_submitted date,
    year character varying(4),
    quarter character varying(4),
    fquarter character varying(8)
);


ALTER TABLE public.epi_generator_questionnaire OWNER TO postgres;

--
-- Name: geo_levels_seq_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE geo_levels_seq_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.geo_levels_seq_id OWNER TO postgres;

--
-- Name: epi_geo_levels; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_geo_levels (
    pk_id integer DEFAULT nextval('geo_levels_seq_id'::regclass) NOT NULL,
    geo_level_name character varying(100) NOT NULL,
    description text,
    status integer DEFAULT 1,
    created_by text NOT NULL,
    created_date timestamp without time zone NOT NULL,
    modified_by text,
    modified_date timestamp without time zone
);


ALTER TABLE public.epi_geo_levels OWNER TO postgres;

--
-- Name: epi_hf_questionnaire_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epi_hf_questionnaire_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.epi_hf_questionnaire_id_seq OWNER TO postgres;

--
-- Name: epi_hf_questionnaire; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_hf_questionnaire (
    id integer DEFAULT nextval('epi_hf_questionnaire_id_seq'::regclass) NOT NULL,
    procode character varying(1),
    distcode character varying(3),
    tcode character varying(6),
    uncode character varying(9),
    facode character varying(6),
    fatype character varying(6),
    tot_pop integer,
    live_births integer,
    no_preg_women integer,
    no_child_bearing_age integer,
    vaccine_storage character varying(5),
    type_of_services character varying(5),
    epi_vaccinators integer,
    epi_dispensers integer,
    epi_store_keepers integer,
    epi_dsv integer,
    epi_asv integer,
    epi_lhvs integer,
    epi_lhss integer,
    epi_lhws integer,
    epi_technicians_cc integer,
    epi_others integer,
    trained_vaccinators integer,
    trained_dispensers integer,
    trained_store_keepers integer,
    trained_dsv integer,
    trained_asv integer,
    trained_lhvs integer,
    trained_lhss integer,
    trained_lhws integer,
    trained_technician_cc integer,
    trained_others integer,
    resupply_interval integer,
    reserve_stock integer,
    routine_immune_req double precision,
    snid_req double precision,
    distance_vss double precision,
    mode_vacc_supply integer,
    waste_disposal character varying(11),
    stock_out_3_months integer,
    grid_elec_available integer,
    solar_energy character varying(5),
    pr_name character varying(150),
    pr_desg character varying(100),
    pr_mob character varying(30),
    pr_email character varying(50),
    pr_date date,
    cctl_name character varying(150),
    cctl_desg character varying(100),
    cctl_mob character varying(30),
    cctl_email character varying(50),
    cctl_date date,
    dc_name character varying(150),
    dc_desg character varying(100),
    dc_email character varying(50),
    dc_mob character varying(30),
    dc_date date,
    other_fatype character varying(500),
    date_submitted date
);


ALTER TABLE public.epi_hf_questionnaire OWNER TO postgres;

--
-- Name: item_category_seq_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE item_category_seq_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.item_category_seq_id OWNER TO postgres;

--
-- Name: epi_item_categories; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_item_categories (
    pk_id integer DEFAULT nextval('item_category_seq_id'::regclass) NOT NULL,
    item_category_name character varying(100) NOT NULL,
    status integer DEFAULT 1,
    created_by text,
    created_date timestamp without time zone,
    modified_by text,
    modified_date timestamp without time zone
);


ALTER TABLE public.epi_item_categories OWNER TO postgres;

--
-- Name: item_pack_sizes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE item_pack_sizes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.item_pack_sizes_id_seq OWNER TO postgres;

--
-- Name: epi_item_pack_sizes; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_item_pack_sizes (
    pk_id integer DEFAULT nextval('item_pack_sizes_id_seq'::regclass) NOT NULL,
    item_name character varying(100) NOT NULL,
    description text,
    number_of_doses integer,
    status integer,
    list_rank integer,
    multiplier integer,
    wastage_rate_allowed double precision,
    item_category_id integer,
    item_unit_id integer,
    item_id integer,
    activity_type_id integer,
    vvm_stage_type integer,
    cr_table_row_numb integer,
    cerv_item integer DEFAULT 0
);


ALTER TABLE public.epi_item_pack_sizes OWNER TO postgres;

--
-- Name: item_units_seq_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE item_units_seq_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.item_units_seq_id OWNER TO postgres;

--
-- Name: epi_item_units; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_item_units (
    pk_id integer DEFAULT nextval('item_units_seq_id'::regclass) NOT NULL,
    item_unit_name character varying(100) NOT NULL,
    status integer DEFAULT 1,
    created_by text,
    created_date timestamp without time zone,
    modified_by text,
    modified_date timestamp without time zone
);


ALTER TABLE public.epi_item_units OWNER TO postgres;

--
-- Name: item_seq_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE item_seq_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.item_seq_id OWNER TO postgres;

--
-- Name: epi_items; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_items (
    pk_id integer DEFAULT nextval('item_seq_id'::regclass) NOT NULL,
    description text,
    pack_volumn double precision,
    doses_per_year integer,
    pack_diluent_volumn double precision,
    target_population_factor integer,
    item_category_id integer,
    population_percent_increase_per_year double precision,
    child_surviving_percent_per_year double precision,
    created_by text,
    created_date timestamp without time zone,
    modified_by text,
    modified_date timestamp without time zone,
    list_order integer,
    in_doses boolean,
    is_active integer DEFAULT 1
);


ALTER TABLE public.epi_items OWNER TO postgres;

--
-- Name: COLUMN epi_items.in_doses; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN epi_items.in_doses IS 'it means this item can be use in doses because it can last longer on rom temp';


--
-- Name: manufacturer_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE manufacturer_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.manufacturer_id_seq OWNER TO postgres;

--
-- Name: epi_manufacturer; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_manufacturer (
    id integer DEFAULT nextval('manufacturer_id_seq'::regclass) NOT NULL,
    name character varying(50)
);


ALTER TABLE public.epi_manufacturer OWNER TO postgres;

--
-- Name: epi_modules; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_modules (
    pk_id integer NOT NULL,
    name character varying(255) NOT NULL,
    active integer DEFAULT 1 NOT NULL
);


ALTER TABLE public.epi_modules OWNER TO postgres;

--
-- Name: TABLE epi_modules; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE epi_modules IS 'All Modules of the system will be mentioned in this table';


--
-- Name: nonccmlocations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE nonccmlocations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.nonccmlocations_id_seq OWNER TO postgres;

--
-- Name: epi_non_ccm_locations; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_non_ccm_locations (
    pk_id integer DEFAULT nextval('nonccmlocations_id_seq'::regclass) NOT NULL,
    location_name character varying(5) NOT NULL,
    warehouse_type_id integer NOT NULL,
    procode character varying(1),
    distcode character varying(3),
    tcode character varying(6),
    uncode character varying(9),
    facode character varying(6),
    rack_information_id integer NOT NULL,
    store integer NOT NULL,
    "row" character(1) NOT NULL,
    rack integer NOT NULL,
    shelf character(1) NOT NULL,
    bin integer NOT NULL,
    warehouse_code character varying(100),
    created_by text,
    created_date timestamp without time zone
);


ALTER TABLE public.epi_non_ccm_locations OWNER TO postgres;

--
-- Name: rackinformation_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE rackinformation_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.rackinformation_id_seq OWNER TO postgres;

--
-- Name: epi_non_ccm_rack_information; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_non_ccm_rack_information (
    pk_id integer DEFAULT nextval('rackinformation_id_seq'::regclass) NOT NULL,
    rack_type character varying(50),
    no_of_bins integer,
    bin_net_capacity double precision,
    gross_capacity double precision,
    capacity_unit character varying(50),
    created_by text,
    created_date timestamp without time zone,
    modified_by text,
    modified_date timestamp without time zone
);


ALTER TABLE public.epi_non_ccm_rack_information OWNER TO postgres;

--
-- Name: epi_refrigerator_questionnaire_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epi_refrigerator_questionnaire_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.epi_refrigerator_questionnaire_id_seq OWNER TO postgres;

--
-- Name: epi_refrigerator_questionnaire; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_refrigerator_questionnaire (
    id integer DEFAULT nextval('epi_refrigerator_questionnaire_id_seq'::regclass) NOT NULL,
    equip_rec text,
    rec_of text,
    procode character varying(1),
    distcode character varying(3),
    tcode character varying(6),
    uncode character varying(9),
    facode character varying(6),
    equip_code character varying(150),
    catalogue_id character varying(100),
    serial_number character varying(150),
    year_first_use character varying(4),
    working_status integer,
    ws_comments text,
    equip_not_working_reason character varying(10),
    equip_utilisation integer,
    temp_monitored character varying(10),
    no_temp_alarms_above integer,
    no_temp_alarms_below integer,
    model_name character varying(100),
    manufacturer character varying(100),
    cfc_sticker integer,
    refrigerator_type integer,
    plus_length double precision,
    plus_width double precision,
    plus_height double precision,
    minus_length double precision,
    minus_width double precision,
    minus_height double precision,
    plus_gross double precision,
    plus_net double precision,
    minus_gross double precision,
    minus_net double precision,
    pr_name character varying(150),
    pr_desg character varying(100),
    pr_mob character varying(30),
    pr_email character varying(50),
    cctl_name character varying(150),
    cctl_mob character varying(30),
    cctl_date date,
    dc_name character varying(150),
    dc_desg character varying(100),
    dc_email character varying(50),
    dc_mob character varying(30),
    dc_date date,
    date_submitted date,
    equip_found character varying(3),
    year character varying(4),
    quarter character varying(4),
    fquarter character varying(8)
);


ALTER TABLE public.epi_refrigerator_questionnaire OWNER TO postgres;

--
-- Name: epi_sections; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_sections (
    secid character varying(10) NOT NULL,
    description character varying(100) NOT NULL,
    rows integer,
    columns integer,
    module_id character varying(3),
    parent_dd_value character varying(20)
);


ALTER TABLE public.epi_sections OWNER TO postgres;

--
-- Name: epi_stackholder_activity_seq_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epi_stackholder_activity_seq_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999
    CACHE 1;


ALTER TABLE public.epi_stackholder_activity_seq_id OWNER TO postgres;

--
-- Name: epi_stackholder_sector_seq_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epi_stackholder_sector_seq_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999
    CACHE 1;


ALTER TABLE public.epi_stackholder_sector_seq_id OWNER TO postgres;

--
-- Name: stakeholder_activities_seq_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE stakeholder_activities_seq_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.stakeholder_activities_seq_id OWNER TO postgres;

--
-- Name: epi_stakeholder_activities; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_stakeholder_activities (
    pk_id integer DEFAULT nextval('stakeholder_activities_seq_id'::regclass) NOT NULL,
    activity character varying(255) NOT NULL,
    created_by text,
    created_date timestamp without time zone,
    modified_by text,
    modified_date timestamp without time zone,
    status integer DEFAULT 1
);


ALTER TABLE public.epi_stakeholder_activities OWNER TO postgres;

--
-- Name: stakeholders_item_pack_sizes_seq_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE stakeholders_item_pack_sizes_seq_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.stakeholders_item_pack_sizes_seq_id OWNER TO postgres;

--
-- Name: epi_stakeholder_item_pack_sizes; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_stakeholder_item_pack_sizes (
    pk_id integer DEFAULT nextval('stakeholders_item_pack_sizes_seq_id'::regclass) NOT NULL,
    pack_size_description text,
    length double precision,
    width double precision,
    height double precision,
    batch_no_start_position integer,
    batch_no_end_position integer,
    expiry_date_start_position integer,
    expiry_date_end_position integer,
    gtin_start_position integer,
    gtin_end_position integer,
    quantity_per_pack integer,
    volume_per_unit_net double precision,
    pre_printed_barcode integer,
    status integer,
    list_rank integer,
    volume_per_vial double precision,
    gtin integer,
    batch integer,
    expiry integer,
    item_gtin character varying(20),
    expiry_date_format integer,
    barcode_type integer,
    stakeholder_id integer,
    item_pack_size_id integer
);


ALTER TABLE public.epi_stakeholder_item_pack_sizes OWNER TO postgres;

--
-- Name: stakeholder_sector_seq_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE stakeholder_sector_seq_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.stakeholder_sector_seq_id OWNER TO postgres;

--
-- Name: epi_stakeholder_sectors; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_stakeholder_sectors (
    pk_id integer DEFAULT nextval('stakeholder_sector_seq_id'::regclass) NOT NULL,
    stakeholder_sector_name character varying(100) NOT NULL,
    status integer DEFAULT 1,
    created_by text,
    created_date timestamp without time zone,
    modified_by text,
    modified_date timestamp without time zone
);


ALTER TABLE public.epi_stakeholder_sectors OWNER TO postgres;

--
-- Name: epi_stakeholder_seq_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epi_stakeholder_seq_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999
    CACHE 1;


ALTER TABLE public.epi_stakeholder_seq_id OWNER TO postgres;

--
-- Name: epi_stakeholder_type_seq_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epi_stakeholder_type_seq_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999
    CACHE 1;


ALTER TABLE public.epi_stakeholder_type_seq_id OWNER TO postgres;

--
-- Name: stakeholder_types_seq_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE stakeholder_types_seq_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.stakeholder_types_seq_id OWNER TO postgres;

--
-- Name: epi_stakeholder_types; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_stakeholder_types (
    pk_id integer DEFAULT nextval('stakeholder_types_seq_id'::regclass) NOT NULL,
    stakeholder_type_name character varying(100) NOT NULL,
    status integer DEFAULT 1,
    created_by text,
    created_date timestamp without time zone,
    modified_by text,
    modified_date timestamp without time zone
);


ALTER TABLE public.epi_stakeholder_types OWNER TO postgres;

--
-- Name: stakeholders_seq_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE stakeholders_seq_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.stakeholders_seq_id OWNER TO postgres;

--
-- Name: epi_stakeholders; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_stakeholders (
    pk_id integer DEFAULT nextval('stakeholders_seq_id'::regclass) NOT NULL,
    stakeholder_name character varying(100) NOT NULL,
    list_rank integer,
    parent_id integer,
    stakeholder_type_id integer NOT NULL,
    stakeholder_sector_id integer NOT NULL,
    geo_level_id integer NOT NULL,
    main_stakeholder integer,
    stakeholder_activity_id integer
);


ALTER TABLE public.epi_stakeholders OWNER TO postgres;

--
-- Name: stock_batch_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE stock_batch_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.stock_batch_id_seq OWNER TO postgres;

--
-- Name: epi_stock_batch; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_stock_batch (
    pk_id integer DEFAULT nextval('stock_batch_id_seq'::regclass) NOT NULL,
    number character varying(100),
    batch_master_id integer,
    expiry_date date,
    quantity integer DEFAULT 0 NOT NULL,
    status character varying(20) DEFAULT 'Stacked'::character varying NOT NULL,
    unit_price double precision NOT NULL,
    production_date date,
    last_update timestamp without time zone,
    item_pack_size_id integer,
    vvm_type_id integer,
    stakeholder_id integer,
    warehouse_type_id integer,
    code character varying(100),
    created_by text NOT NULL,
    created_date timestamp without time zone,
    ccm_id integer,
    non_ccm_id integer,
    parent_pk_id integer
);


ALTER TABLE public.epi_stock_batch OWNER TO postgres;

--
-- Name: stock_batch_history_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE stock_batch_history_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.stock_batch_history_id_seq OWNER TO postgres;

--
-- Name: epi_stock_batch_history; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_stock_batch_history (
    pk_id integer DEFAULT nextval('stock_batch_history_id_seq'::regclass) NOT NULL,
    batch_id integer NOT NULL,
    number character varying(100),
    batch_master_id integer,
    expiry_date date,
    quantity integer NOT NULL,
    status character varying(20) DEFAULT 'Stacked'::character varying NOT NULL,
    unit_price double precision NOT NULL,
    production_date date,
    last_update timestamp without time zone,
    item_pack_size_id integer,
    vvm_type_id integer,
    stakeholder_id integer,
    warehouse_type_id integer,
    code character varying(100),
    created_by text NOT NULL,
    created_date timestamp without time zone,
    ccm_id integer,
    non_ccm_id integer,
    parent_pk_id integer
);


ALTER TABLE public.epi_stock_batch_history OWNER TO postgres;

--
-- Name: stock_detail_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE stock_detail_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.stock_detail_id_seq OWNER TO postgres;

--
-- Name: epi_stock_detail; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_stock_detail (
    pk_id integer DEFAULT nextval('stock_detail_id_seq'::regclass) NOT NULL,
    quantity integer NOT NULL,
    temporary integer DEFAULT 0,
    vvm_stage character varying(100),
    is_received integer,
    adjustment_type integer,
    stock_master_id integer NOT NULL,
    stock_batch_id integer NOT NULL,
    item_unit_id integer NOT NULL,
    created_by text NOT NULL,
    created_date timestamp without time zone,
    rec_adjustment integer DEFAULT 0
);


ALTER TABLE public.epi_stock_detail OWNER TO postgres;

--
-- Name: stock_detail_history_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE stock_detail_history_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.stock_detail_history_id_seq OWNER TO postgres;

--
-- Name: epi_stock_detail_history; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_stock_detail_history (
    pk_id integer DEFAULT nextval('stock_detail_history_id_seq'::regclass) NOT NULL,
    detail_id integer NOT NULL,
    quantity integer NOT NULL,
    temporary integer,
    vvm_stage character varying(100),
    is_received integer,
    adjustment_type integer,
    stock_master_id integer NOT NULL,
    stock_batch_id integer NOT NULL,
    item_unit_id integer NOT NULL,
    created_by text NOT NULL,
    created_date timestamp without time zone,
    rec_adjustment integer DEFAULT 0
);


ALTER TABLE public.epi_stock_detail_history OWNER TO postgres;

--
-- Name: epi_stock_management_seq_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epi_stock_management_seq_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999
    CACHE 1;


ALTER TABLE public.epi_stock_management_seq_id OWNER TO postgres;

--
-- Name: epi_stock_management; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_stock_management (
    id integer DEFAULT nextval('epi_stock_management_seq_id'::regclass) NOT NULL,
    ref_no character varying(25),
    supply_from character varying(25),
    issue_to integer,
    issue_date date,
    product_id character varying(25),
    manufacturer_id integer,
    recive_date date,
    purpose_id integer,
    funding_source_id integer,
    issue_vials integer,
    receive_vials integer,
    location_id integer,
    vvm_stage_issue integer,
    vvm_stage_receive integer,
    batch_no character varying(25),
    expiry_date date,
    unit_cost integer,
    designation character varying(30),
    received_by character varying(30),
    date_by date,
    adjustmenttype character varying(25),
    adjustmentqty character varying(25) NOT NULL,
    form_id integer DEFAULT 1
);


ALTER TABLE public.epi_stock_management OWNER TO postgres;

--
-- Name: stock_master_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE stock_master_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.stock_master_id_seq OWNER TO postgres;

--
-- Name: epi_stock_master; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_stock_master (
    pk_id integer DEFAULT nextval('stock_master_id_seq'::regclass) NOT NULL,
    transaction_date timestamp without time zone,
    transaction_number character varying(100),
    transaction_counter integer,
    transaction_reference character varying(100),
    draft smallint DEFAULT 1 NOT NULL,
    comments text,
    transaction_type_id integer NOT NULL,
    from_warehouse_type_id integer NOT NULL,
    from_warehouse_code character varying(100),
    to_warehouse_type_id integer NOT NULL,
    to_warehouse_code character varying(100),
    parent_id integer,
    campaign_id integer,
    stakeholder_activity_id integer NOT NULL,
    created_by text NOT NULL,
    created_date timestamp without time zone,
    updated_date timestamp without time zone
);


ALTER TABLE public.epi_stock_master OWNER TO postgres;

--
-- Name: epi_stock_master_fed_fetch; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_stock_master_fed_fetch (
    pk_id integer DEFAULT nextval('stock_master_id_seq'::regclass) NOT NULL,
    fetch_date date,
    transaction_number character varying(100),
    fed_transaction_number character varying(100),
    created_by text NOT NULL,
    created_date timestamp without time zone
);


ALTER TABLE public.epi_stock_master_fed_fetch OWNER TO postgres;

--
-- Name: stock_master_history_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE stock_master_history_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.stock_master_history_id_seq OWNER TO postgres;

--
-- Name: epi_stock_master_history; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_stock_master_history (
    pk_id integer DEFAULT nextval('stock_master_history_id_seq'::regclass) NOT NULL,
    master_id integer NOT NULL,
    transaction_date timestamp without time zone,
    transaction_number character varying(100),
    transaction_counter integer,
    transaction_reference character varying(100),
    draft smallint DEFAULT 1 NOT NULL,
    comments text,
    transaction_type_id integer NOT NULL,
    from_warehouse_type_id integer NOT NULL,
    from_warehouse_code character varying(100),
    to_warehouse_type_id integer NOT NULL,
    to_warehouse_code character varying(100),
    parent_id integer,
    campaign_id integer,
    stakeholder_activity_id integer NOT NULL,
    created_by text NOT NULL,
    created_date timestamp without time zone,
    updated_date timestamp without time zone
);


ALTER TABLE public.epi_stock_master_history OWNER TO postgres;

--
-- Name: trans_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE trans_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.trans_types_id_seq OWNER TO postgres;

--
-- Name: epi_transaction_types; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_transaction_types (
    pk_id integer DEFAULT nextval('trans_types_id_seq'::regclass) NOT NULL,
    transaction_type_name character varying(50) NOT NULL,
    nature character(1),
    is_adjustment integer,
    status integer DEFAULT 1,
    created_by text NOT NULL,
    created_date timestamp without time zone NOT NULL,
    modified_by text,
    modified_date timestamp without time zone
);


ALTER TABLE public.epi_transaction_types OWNER TO postgres;

--
-- Name: epi_vacc_products_details; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_vacc_products_details (
    id integer NOT NULL,
    vacc_id character varying(50),
    name character varying(50),
    doses integer
);


ALTER TABLE public.epi_vacc_products_details OWNER TO postgres;

--
-- Name: TABLE epi_vacc_products_details; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE epi_vacc_products_details IS 'For communication with vlmis';


--
-- Name: epi_village_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epi_village_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.epi_village_id_seq OWNER TO postgres;

--
-- Name: epi_voltage_questionnaire_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epi_voltage_questionnaire_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.epi_voltage_questionnaire_id_seq OWNER TO postgres;

--
-- Name: epi_voltage_questionnaire; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_voltage_questionnaire (
    id integer DEFAULT nextval('epi_voltage_questionnaire_id_seq'::regclass) NOT NULL,
    equip_rec text,
    rec_of text,
    procode character varying(1),
    distcode character varying(3),
    tcode character varying(6),
    uncode character varying(9),
    facode character varying(6),
    equip_code character varying(150),
    catalogue_id character varying(100),
    manufacturer character varying(100),
    model character varying(100),
    quantity_present integer,
    quantity_not_working integer,
    pr_name character varying(150),
    pr_desg character varying(100),
    pr_mob character varying(30),
    pr_email character varying(50),
    cctl_name character varying(150),
    cctl_desg character varying(100),
    cctl_mob character varying(30),
    dc_name character varying(150),
    dc_desg character varying(100),
    dc_email character varying(50),
    dc_mob character varying(30),
    dc_date date,
    cctl_email character varying(50),
    date_submitted date,
    year character varying(4),
    quarter character varying(4),
    fquarter character varying(8)
);


ALTER TABLE public.epi_voltage_questionnaire OWNER TO postgres;

--
-- Name: vvm_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE vvm_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.vvm_types_id_seq OWNER TO postgres;

--
-- Name: epi_vvm_types; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_vvm_types (
    pk_id integer DEFAULT nextval('vvm_types_id_seq'::regclass) NOT NULL,
    vvm_type_name character varying(100) NOT NULL,
    status integer DEFAULT 1,
    item_pack_size_id integer,
    created_by text,
    created_date timestamp without time zone,
    modified_by text,
    modified_date timestamp without time zone,
    list_rank integer DEFAULT 1 NOT NULL
);


ALTER TABLE public.epi_vvm_types OWNER TO postgres;

--
-- Name: epi_week_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epi_week_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999999999
    CACHE 1;


ALTER TABLE public.epi_week_seq OWNER TO postgres;

--
-- Name: epi_weeks; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epi_weeks (
    recid integer DEFAULT nextval('epi_week_seq'::regclass) NOT NULL,
    epi_week_numb integer NOT NULL,
    date_from date NOT NULL,
    date_to date NOT NULL,
    year character varying(4) NOT NULL,
    fweek character varying(7),
    month integer
);


ALTER TABLE public.epi_weeks OWNER TO postgres;

--
-- Name: epidcount_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epidcount_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.epidcount_id_seq OWNER TO postgres;

--
-- Name: epidcount_db; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epidcount_db (
    pk_id integer DEFAULT nextval('epidcount_id_seq'::regclass) NOT NULL,
    procode character varying(1) NOT NULL,
    distcode character varying(3) NOT NULL,
    case_type character varying(30) NOT NULL,
    mwk01 integer DEFAULT 0,
    mwk02 integer DEFAULT 0,
    mwk03 integer DEFAULT 0,
    mwk04 integer DEFAULT 0,
    mwk05 integer DEFAULT 0,
    mwk06 integer DEFAULT 0,
    mwk07 integer DEFAULT 0,
    mwk08 integer DEFAULT 0,
    mwk09 integer DEFAULT 0,
    mwk10 integer DEFAULT 0,
    mwk11 integer DEFAULT 0,
    mwk12 integer DEFAULT 0,
    mwk13 integer DEFAULT 0,
    mwk14 integer DEFAULT 0,
    mwk15 integer DEFAULT 0,
    mwk16 integer DEFAULT 0,
    mwk17 integer DEFAULT 0,
    mwk18 integer DEFAULT 0,
    mwk19 integer DEFAULT 0,
    mwk20 integer DEFAULT 0,
    mwk21 integer DEFAULT 0,
    mwk22 integer DEFAULT 0,
    mwk23 integer DEFAULT 0,
    mwk24 integer DEFAULT 0,
    mwk25 integer DEFAULT 0,
    mwk26 integer DEFAULT 0,
    mwk27 integer DEFAULT 0,
    mwk28 integer DEFAULT 0,
    mwk29 integer DEFAULT 0,
    mwk30 integer DEFAULT 0,
    mwk31 integer DEFAULT 0,
    mwk32 integer DEFAULT 0,
    mwk33 integer DEFAULT 0,
    mwk34 integer DEFAULT 0,
    mwk35 integer DEFAULT 0,
    mwk36 integer DEFAULT 0,
    mwk37 integer DEFAULT 0,
    mwk38 integer DEFAULT 0,
    mwk39 integer DEFAULT 0,
    mwk40 integer DEFAULT 0,
    mwk41 integer DEFAULT 0,
    mwk42 integer DEFAULT 0,
    mwk43 integer DEFAULT 0,
    mwk44 integer DEFAULT 0,
    mwk45 integer DEFAULT 0,
    mwk46 integer DEFAULT 0,
    mwk47 integer DEFAULT 0,
    mwk48 integer DEFAULT 0,
    mwk49 integer DEFAULT 0,
    mwk50 integer DEFAULT 0,
    mwk51 integer DEFAULT 0,
    mwk52 integer DEFAULT 0,
    mwk53 integer DEFAULT 0,
    year character varying(4) NOT NULL,
    fwk01 integer DEFAULT 0,
    fwk02 integer DEFAULT 0,
    fwk03 integer DEFAULT 0,
    fwk04 integer DEFAULT 0,
    fwk05 integer DEFAULT 0,
    fwk06 integer DEFAULT 0,
    fwk07 integer DEFAULT 0,
    fwk08 integer DEFAULT 0,
    fwk09 integer DEFAULT 0,
    fwk10 integer DEFAULT 0,
    fwk11 integer DEFAULT 0,
    fwk12 integer DEFAULT 0,
    fwk13 integer DEFAULT 0,
    fwk14 integer DEFAULT 0,
    fwk15 integer DEFAULT 0,
    fwk16 integer DEFAULT 0,
    fwk17 integer DEFAULT 0,
    fwk18 integer DEFAULT 0,
    fwk19 integer DEFAULT 0,
    fwk20 integer DEFAULT 0,
    fwk21 integer DEFAULT 0,
    fwk22 integer DEFAULT 0,
    fwk23 integer DEFAULT 0,
    fwk24 integer DEFAULT 0,
    fwk25 integer DEFAULT 0,
    fwk26 integer DEFAULT 0,
    fwk27 integer DEFAULT 0,
    fwk28 integer DEFAULT 0,
    fwk29 integer DEFAULT 0,
    fwk30 integer DEFAULT 0,
    fwk31 integer DEFAULT 0,
    fwk32 integer DEFAULT 0,
    fwk33 integer DEFAULT 0,
    fwk34 integer DEFAULT 0,
    fwk35 integer DEFAULT 0,
    fwk36 integer DEFAULT 0,
    fwk37 integer DEFAULT 0,
    fwk38 integer DEFAULT 0,
    fwk39 integer DEFAULT 0,
    fwk40 integer DEFAULT 0,
    fwk41 integer DEFAULT 0,
    fwk42 integer DEFAULT 0,
    fwk43 integer DEFAULT 0,
    fwk44 integer DEFAULT 0,
    fwk45 integer DEFAULT 0,
    fwk46 integer DEFAULT 0,
    fwk47 integer DEFAULT 0,
    fwk48 integer DEFAULT 0,
    fwk49 integer DEFAULT 0,
    fwk50 integer DEFAULT 0,
    fwk51 integer DEFAULT 0,
    fwk52 integer DEFAULT 0,
    fwk53 integer DEFAULT 0
);


ALTER TABLE public.epidcount_db OWNER TO postgres;

--
-- Name: epidmr_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epidmr_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999999
    CACHE 1;


ALTER TABLE public.epidmr_id_seq OWNER TO postgres;

--
-- Name: epidmr; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epidmr (
    id integer DEFAULT nextval('epidmr_id_seq'::regclass) NOT NULL,
    distcode character varying(3) NOT NULL,
    tot_uc integer DEFAULT 0,
    tot_epi_center integer DEFAULT 0,
    fmonth character varying(8) NOT NULL,
    fixed_planned double precision DEFAULT 0,
    fixed_conducted double precision DEFAULT 0,
    outreach_planned double precision DEFAULT 0,
    outreach_conducted double precision DEFAULT 0,
    mobile_planned double precision DEFAULT 0,
    mobile_conducted double precision DEFAULT 0,
    health_houses_planned double precision DEFAULT 0,
    health_houses_conducted double precision DEFAULT 0,
    tot_population double precision DEFAULT 0,
    tot_target_children double precision DEFAULT 0,
    monthly_birth_target double precision DEFAULT 0,
    monthly_surviving_target double precision DEFAULT 0,
    monthly_pregnant_target double precision DEFAULT 0,
    cv_r1_f1 double precision DEFAULT 0,
    cv_r1_f2 double precision DEFAULT 0,
    cv_r1_f3 double precision DEFAULT 0,
    cv_r1_f4 double precision DEFAULT 0,
    cv_r2_f1 double precision DEFAULT 0,
    cv_r2_f2 double precision DEFAULT 0,
    cv_r2_f3 double precision DEFAULT 0,
    cv_r2_f4 double precision DEFAULT 0,
    cv_r3_f1 double precision DEFAULT 0,
    cv_r3_f2 double precision DEFAULT 0,
    cv_r3_f3 double precision DEFAULT 0,
    cv_r3_f4 double precision DEFAULT 0,
    cv_r4_f1 double precision DEFAULT 0,
    cv_r4_f2 double precision DEFAULT 0,
    cv_r4_f3 double precision DEFAULT 0,
    cv_r4_f4 double precision DEFAULT 0,
    cv_r5_f1 double precision DEFAULT 0,
    cv_r5_f2 double precision DEFAULT 0,
    cv_r5_f3 double precision DEFAULT 0,
    cv_r5_f4 double precision DEFAULT 0,
    cv_r6_f1 double precision DEFAULT 0,
    cv_r6_f2 double precision DEFAULT 0,
    cv_r6_f3 double precision DEFAULT 0,
    cv_r6_f4 double precision DEFAULT 0,
    cv_r7_f1 double precision DEFAULT 0,
    cv_r7_f2 double precision DEFAULT 0,
    cv_r7_f3 double precision DEFAULT 0,
    cv_r7_f4 double precision DEFAULT 0,
    cv_r8_f1 double precision DEFAULT 0,
    cv_r8_f2 double precision DEFAULT 0,
    cv_r8_f3 double precision DEFAULT 0,
    cv_r8_f4 double precision DEFAULT 0,
    cv_r9_f1 double precision DEFAULT 0,
    cv_r9_f2 double precision DEFAULT 0,
    cv_r9_f3 double precision DEFAULT 0,
    cv_r9_f4 double precision DEFAULT 0,
    cv_r10_f1 double precision DEFAULT 0,
    cv_r10_f2 double precision DEFAULT 0,
    cv_r10_f3 double precision DEFAULT 0,
    cv_r10_f4 double precision DEFAULT 0,
    cv_r11_f1 double precision DEFAULT 0,
    cv_r11_f2 double precision DEFAULT 0,
    cv_r11_f3 double precision DEFAULT 0,
    cv_r11_f4 double precision DEFAULT 0,
    cv_r12_f1 double precision DEFAULT 0,
    cv_r12_f2 double precision DEFAULT 0,
    cv_r12_f3 double precision DEFAULT 0,
    cv_r12_f4 double precision DEFAULT 0,
    cv_r13_f1 double precision DEFAULT 0,
    cv_r13_f2 double precision DEFAULT 0,
    cv_r13_f3 double precision DEFAULT 0,
    cv_r13_f4 double precision DEFAULT 0,
    cv_r14_f1 double precision DEFAULT 0,
    cv_r14_f2 double precision DEFAULT 0,
    cv_r14_f3 double precision DEFAULT 0,
    cv_r14_f4 double precision DEFAULT 0,
    wv_r1_f1 double precision DEFAULT 0,
    wv_r1_f2 double precision DEFAULT 0,
    wv_r1_f3 double precision DEFAULT 0,
    wv_r1_f4 double precision DEFAULT 0,
    wv_r2_f1 double precision DEFAULT 0,
    wv_r2_f2 double precision DEFAULT 0,
    wv_r2_f3 double precision DEFAULT 0,
    wv_r2_f4 double precision DEFAULT 0,
    wv_r3_f1 double precision DEFAULT 0,
    wv_r3_f2 double precision DEFAULT 0,
    wv_r3_f3 double precision DEFAULT 0,
    wv_r3_f4 double precision DEFAULT 0,
    wv_r4_f1 double precision DEFAULT 0,
    wv_r4_f2 double precision DEFAULT 0,
    wv_r4_f3 double precision DEFAULT 0,
    wv_r4_f4 double precision DEFAULT 0,
    wv_r5_f1 double precision DEFAULT 0,
    wv_r5_f2 double precision DEFAULT 0,
    wv_r5_f3 double precision DEFAULT 0,
    wv_r5_f4 double precision DEFAULT 0,
    wv_r6_f1 double precision DEFAULT 0,
    wv_r6_f2 double precision DEFAULT 0,
    wv_r6_f3 double precision DEFAULT 0,
    wv_r6_f4 double precision DEFAULT 0,
    wv_r7_f1 double precision DEFAULT 0,
    wv_r7_f2 double precision DEFAULT 0,
    wv_r7_f3 double precision DEFAULT 0,
    wv_r7_f4 double precision DEFAULT 0,
    wv_r8_f1 double precision DEFAULT 0,
    wv_r8_f2 double precision DEFAULT 0,
    wv_r8_f3 double precision DEFAULT 0,
    wv_r8_f4 double precision DEFAULT 0,
    wv_r9_f1 double precision DEFAULT 0,
    wv_r9_f2 double precision DEFAULT 0,
    wv_r9_f3 double precision DEFAULT 0,
    wv_r9_f4 double precision DEFAULT 0,
    wv_r10_f1 double precision DEFAULT 0,
    wv_r10_f2 double precision DEFAULT 0,
    wv_r10_f3 double precision DEFAULT 0,
    wv_r10_f4 double precision DEFAULT 0,
    dsv_name text,
    cord_name text,
    dho_name text,
    procode character varying(1) DEFAULT '3'::character varying,
    bcg_total double precision DEFAULT 0,
    polio_total double precision DEFAULT 0,
    birth_hepb_total double precision DEFAULT 0,
    polio_1_total double precision DEFAULT 0,
    polio_2_total double precision DEFAULT 0,
    polio_3_total double precision DEFAULT 0,
    penta_1_total double precision DEFAULT 0,
    penta_2_total double precision DEFAULT 0,
    penta_3_total double precision DEFAULT 0,
    pcv_1_total double precision DEFAULT 0,
    pcv_2_total double precision DEFAULT 0,
    pcv_3_total double precision DEFAULT 0,
    measles_1_total double precision DEFAULT 0,
    measles_2_total double precision DEFAULT 0,
    tt1_fixed_total double precision DEFAULT 0,
    tt1_outreach_total double precision DEFAULT 0,
    tt1_mobile_total double precision DEFAULT 0,
    tt1_healthhouse_total double precision DEFAULT 0,
    tt1_pl_total double precision DEFAULT 0,
    tt1_cba_total double precision DEFAULT 0,
    tt1_all_total double precision DEFAULT 0,
    tt2_fixed_total double precision DEFAULT 0,
    tt2_outreach_total double precision DEFAULT 0,
    tt2_mobile_total double precision DEFAULT 0,
    tt2_healthhouse_total double precision DEFAULT 0,
    tt2_pl_total double precision DEFAULT 0,
    tt2_cba_total double precision DEFAULT 0,
    tt2_all_total double precision DEFAULT 0,
    tt3_fixed_total double precision DEFAULT 0,
    tt3_outreach_total double precision DEFAULT 0,
    tt3_mobile_total double precision DEFAULT 0,
    tt3_healthhouse_total double precision DEFAULT 0,
    tt3_pl_total double precision DEFAULT 0,
    tt3_cba_total double precision DEFAULT 0,
    tt3_all_total double precision DEFAULT 0,
    tt4_fixed_total double precision DEFAULT 0,
    tt4_outreach_total double precision DEFAULT 0,
    tt4_mobile_total double precision DEFAULT 0,
    tt4_healthhouse_total double precision DEFAULT 0,
    tt4_pl_total double precision DEFAULT 0,
    tt4_cba_total double precision DEFAULT 0,
    tt4_all_total double precision DEFAULT 0,
    tt5_fixed_total double precision DEFAULT 0,
    tt5_outreach_total double precision DEFAULT 0,
    tt5_mobile_total double precision DEFAULT 0,
    tt5_healthhouse_total double precision DEFAULT 0,
    tt5_pl_total double precision DEFAULT 0,
    tt5_cba_total double precision DEFAULT 0,
    tt5_all_total double precision DEFAULT 0
);


ALTER TABLE public.epidmr OWNER TO postgres;

--
-- Name: epifieldtitles_recid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epifieldtitles_recid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999999999999999
    CACHE 1
    CYCLE;


ALTER TABLE public.epifieldtitles_recid_seq OWNER TO postgres;

--
-- Name: epifieldstitle; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epifieldstitle (
    recid integer DEFAULT nextval('epifieldtitles_recid_seq'::regclass) NOT NULL,
    secid character varying(25),
    fid character varying(30),
    description character varying(120),
    module_id character varying(3)
);


ALTER TABLE public.epifieldstitle OWNER TO postgres;

--
-- Name: epimis_session; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epimis_session (
    id character varying(40) NOT NULL,
    ip_address character varying(45),
    "timestamp" bigint,
    data text
);


ALTER TABLE public.epimis_session OWNER TO postgres;

--
-- Name: epiusers; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE epiusers (
    username character varying(50) NOT NULL,
    password character varying(50) NOT NULL,
    level character varying(3),
    utype character varying(30),
    distcode character varying(3),
    procode character varying(1),
    addedby integer DEFAULT 0,
    addeddate date DEFAULT now(),
    updateddate date,
    facode character varying DEFAULT 0,
    tcode character varying DEFAULT 0,
    uncode character varying DEFAULT 0,
    batch_status character varying(2) DEFAULT 0,
    fullname character varying(150),
    designation character varying(30),
    name character varying(50),
    department character varying(50),
    email character varying(30),
    cell_no character varying(15),
    active integer DEFAULT 1,
    labuser integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.epiusers OWNER TO postgres;

--
-- Name: COLUMN epiusers.labuser; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN epiusers.labuser IS 'for lab result users column value should be 1';


--
-- Name: epiusers_cell_no_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE epiusers_cell_no_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.epiusers_cell_no_seq OWNER TO postgres;

--
-- Name: export_table; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE export_table (
    pk_id integer,
    main_id integer,
    item_id integer,
    batch_number text,
    batch_doses integer,
    opening_doses integer,
    received_doses integer,
    used_doses integer,
    used_vials double precision,
    unused_doses integer,
    unused_vials double precision,
    closing_doses integer,
    closing_vials double precision,
    vaccinated integer
);


ALTER TABLE public.export_table OWNER TO postgres;

--
-- Name: fac; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE fac (
    sum bigint
);


ALTER TABLE public.fac OWNER TO postgres;

--
-- Name: fac_mvrf_db_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE fac_mvrf_db_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1
    CYCLE;


ALTER TABLE public.fac_mvrf_db_id_seq OWNER TO postgres;

--
-- Name: fac_mvrf_db; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE fac_mvrf_db (
    id integer DEFAULT nextval('fac_mvrf_db_id_seq'::regclass) NOT NULL,
    procode character varying(1) DEFAULT 3,
    distcode character varying(3) NOT NULL,
    facode character varying(6),
    tcode character varying(6) NOT NULL,
    uncode character varying(9),
    fmonth character varying(7),
    tc_male integer DEFAULT 0,
    tc_female integer DEFAULT 0,
    pw_monthly_target integer DEFAULT 0,
    tot_lhw_attached integer DEFAULT 0,
    tot_lhw_involved_vacc integer DEFAULT 0,
    tot_fixed_centers integer DEFAULT 0,
    functioning_centers integer DEFAULT 0,
    reporting_centers integer DEFAULT 0,
    fixed_vacc_planned integer DEFAULT 0,
    fixed_vacc_held integer DEFAULT 0,
    or_vacc_planned integer DEFAULT 0,
    or_vacc_held integer DEFAULT 0,
    hh_vacc_planned integer DEFAULT 0,
    hh_vacc_held integer DEFAULT 0,
    cri_r1_f1 integer DEFAULT 0,
    cri_r2_f1 integer DEFAULT 0,
    cri_r3_f1 integer DEFAULT 0,
    cri_r4_f1 integer DEFAULT 0,
    cri_r5_f1 integer DEFAULT 0,
    cri_r6_f1 integer DEFAULT 0,
    cri_r7_f1 integer DEFAULT 0,
    cri_r8_f1 integer DEFAULT 0,
    cri_r9_f1 integer DEFAULT 0,
    cri_r10_f1 integer DEFAULT 0,
    cri_r11_f1 integer DEFAULT 0,
    cri_r12_f1 integer DEFAULT 0,
    cri_r13_f1 integer DEFAULT 0,
    cri_r14_f1 integer DEFAULT 0,
    cri_r15_f1 integer DEFAULT 0,
    cri_r16_f1 integer DEFAULT 0,
    cri_r17_f1 integer DEFAULT 0,
    cri_r18_f1 integer DEFAULT 0,
    cri_r19_f1 integer DEFAULT 0,
    cri_r20_f1 integer DEFAULT 0,
    cri_r21_f1 integer DEFAULT 0,
    cri_r22_f1 integer DEFAULT 0,
    cri_r23_f1 integer DEFAULT 0,
    cri_r24_f1 integer DEFAULT 0,
    cri_r25_f1 integer DEFAULT 0,
    cri_r26_f1 integer DEFAULT 0,
    cri_r1_f2 integer DEFAULT 0,
    cri_r2_f2 integer DEFAULT 0,
    cri_r3_f2 integer DEFAULT 0,
    cri_r4_f2 integer DEFAULT 0,
    cri_r5_f2 integer DEFAULT 0,
    cri_r6_f2 integer DEFAULT 0,
    cri_r7_f2 integer DEFAULT 0,
    cri_r8_f2 integer DEFAULT 0,
    cri_r9_f2 integer DEFAULT 0,
    cri_r10_f2 integer DEFAULT 0,
    cri_r11_f2 integer DEFAULT 0,
    cri_r12_f2 integer DEFAULT 0,
    cri_r13_f2 integer DEFAULT 0,
    cri_r14_f2 integer DEFAULT 0,
    cri_r15_f2 integer DEFAULT 0,
    cri_r16_f2 integer DEFAULT 0,
    cri_r17_f2 integer DEFAULT 0,
    cri_r18_f2 integer DEFAULT 0,
    cri_r19_f2 integer DEFAULT 0,
    cri_r20_f2 integer DEFAULT 0,
    cri_r21_f2 integer DEFAULT 0,
    cri_r22_f2 integer DEFAULT 0,
    cri_r23_f2 integer DEFAULT 0,
    cri_r24_f2 integer DEFAULT 0,
    cri_r25_f2 integer DEFAULT 0,
    cri_r26_f2 integer DEFAULT 0,
    cri_r1_f3 integer DEFAULT 0,
    cri_r2_f3 integer DEFAULT 0,
    cri_r3_f3 integer DEFAULT 0,
    cri_r4_f3 integer DEFAULT 0,
    cri_r5_f3 integer DEFAULT 0,
    cri_r6_f3 integer DEFAULT 0,
    cri_r7_f3 integer DEFAULT 0,
    cri_r8_f3 integer DEFAULT 0,
    cri_r9_f3 integer DEFAULT 0,
    cri_r10_f3 integer DEFAULT 0,
    cri_r11_f3 integer DEFAULT 0,
    cri_r12_f3 integer DEFAULT 0,
    cri_r13_f3 integer DEFAULT 0,
    cri_r14_f3 integer DEFAULT 0,
    cri_r15_f3 integer DEFAULT 0,
    cri_r16_f3 integer DEFAULT 0,
    cri_r17_f3 integer DEFAULT 0,
    cri_r18_f3 integer DEFAULT 0,
    cri_r19_f3 integer DEFAULT 0,
    cri_r20_f3 integer DEFAULT 0,
    cri_r21_f3 integer DEFAULT 0,
    cri_r22_f3 integer DEFAULT 0,
    cri_r23_f3 integer DEFAULT 0,
    cri_r24_f3 integer DEFAULT 0,
    cri_r25_f3 integer DEFAULT 0,
    cri_r26_f3 integer DEFAULT 0,
    cri_r1_f4 integer DEFAULT 0,
    cri_r2_f4 integer DEFAULT 0,
    cri_r3_f4 integer DEFAULT 0,
    cri_r4_f4 integer DEFAULT 0,
    cri_r5_f4 integer DEFAULT 0,
    cri_r6_f4 integer DEFAULT 0,
    cri_r7_f4 integer DEFAULT 0,
    cri_r8_f4 integer DEFAULT 0,
    cri_r9_f4 integer DEFAULT 0,
    cri_r10_f4 integer DEFAULT 0,
    cri_r11_f4 integer DEFAULT 0,
    cri_r12_f4 integer DEFAULT 0,
    cri_r13_f4 integer DEFAULT 0,
    cri_r14_f4 integer DEFAULT 0,
    cri_r15_f4 integer DEFAULT 0,
    cri_r16_f4 integer DEFAULT 0,
    cri_r17_f4 integer DEFAULT 0,
    cri_r18_f4 integer DEFAULT 0,
    cri_r19_f4 integer DEFAULT 0,
    cri_r20_f4 integer DEFAULT 0,
    cri_r21_f4 integer DEFAULT 0,
    cri_r22_f4 integer DEFAULT 0,
    cri_r23_f4 integer DEFAULT 0,
    cri_r24_f4 integer DEFAULT 0,
    cri_r25_f4 integer DEFAULT 0,
    cri_r26_f4 integer DEFAULT 0,
    cri_r1_f5 integer DEFAULT 0,
    cri_r2_f5 integer DEFAULT 0,
    cri_r3_f5 integer DEFAULT 0,
    cri_r4_f5 integer DEFAULT 0,
    cri_r5_f5 integer DEFAULT 0,
    cri_r6_f5 integer DEFAULT 0,
    cri_r7_f5 integer DEFAULT 0,
    cri_r8_f5 integer DEFAULT 0,
    cri_r9_f5 integer DEFAULT 0,
    cri_r10_f5 integer DEFAULT 0,
    cri_r11_f5 integer DEFAULT 0,
    cri_r12_f5 integer DEFAULT 0,
    cri_r13_f5 integer DEFAULT 0,
    cri_r14_f5 integer DEFAULT 0,
    cri_r15_f5 integer DEFAULT 0,
    cri_r16_f5 integer DEFAULT 0,
    cri_r17_f5 integer DEFAULT 0,
    cri_r18_f5 integer DEFAULT 0,
    cri_r19_f5 integer DEFAULT 0,
    cri_r20_f5 integer DEFAULT 0,
    cri_r21_f5 integer DEFAULT 0,
    cri_r22_f5 integer DEFAULT 0,
    cri_r23_f5 integer DEFAULT 0,
    cri_r24_f5 integer DEFAULT 0,
    cri_r25_f5 integer DEFAULT 0,
    cri_r26_f5 integer DEFAULT 0,
    cri_r1_f6 integer DEFAULT 0,
    cri_r2_f6 integer DEFAULT 0,
    cri_r3_f6 integer DEFAULT 0,
    cri_r4_f6 integer DEFAULT 0,
    cri_r5_f6 integer DEFAULT 0,
    cri_r6_f6 integer DEFAULT 0,
    cri_r7_f6 integer DEFAULT 0,
    cri_r8_f6 integer DEFAULT 0,
    cri_r9_f6 integer DEFAULT 0,
    cri_r10_f6 integer DEFAULT 0,
    cri_r11_f6 integer DEFAULT 0,
    cri_r12_f6 integer DEFAULT 0,
    cri_r13_f6 integer DEFAULT 0,
    cri_r14_f6 integer DEFAULT 0,
    cri_r15_f6 integer DEFAULT 0,
    cri_r16_f6 integer DEFAULT 0,
    cri_r17_f6 integer DEFAULT 0,
    cri_r18_f6 integer DEFAULT 0,
    cri_r19_f6 integer DEFAULT 0,
    cri_r20_f6 integer DEFAULT 0,
    cri_r21_f6 integer DEFAULT 0,
    cri_r22_f6 integer DEFAULT 0,
    cri_r23_f6 integer DEFAULT 0,
    cri_r24_f6 integer DEFAULT 0,
    cri_r25_f6 integer DEFAULT 0,
    cri_r26_f6 integer DEFAULT 0,
    cri_r1_f7 integer DEFAULT 0,
    cri_r2_f7 integer DEFAULT 0,
    cri_r3_f7 integer DEFAULT 0,
    cri_r4_f7 integer DEFAULT 0,
    cri_r5_f7 integer DEFAULT 0,
    cri_r6_f7 integer DEFAULT 0,
    cri_r7_f7 integer DEFAULT 0,
    cri_r8_f7 integer DEFAULT 0,
    cri_r9_f7 integer DEFAULT 0,
    cri_r10_f7 integer DEFAULT 0,
    cri_r11_f7 integer DEFAULT 0,
    cri_r12_f7 integer DEFAULT 0,
    cri_r13_f7 integer DEFAULT 0,
    cri_r14_f7 integer DEFAULT 0,
    cri_r15_f7 integer DEFAULT 0,
    cri_r16_f7 integer DEFAULT 0,
    cri_r17_f7 integer DEFAULT 0,
    cri_r18_f7 integer DEFAULT 0,
    cri_r19_f7 integer DEFAULT 0,
    cri_r20_f7 integer DEFAULT 0,
    cri_r21_f7 integer DEFAULT 0,
    cri_r22_f7 integer DEFAULT 0,
    cri_r23_f7 integer DEFAULT 0,
    cri_r24_f7 integer DEFAULT 0,
    cri_r25_f7 integer DEFAULT 0,
    cri_r26_f7 integer DEFAULT 0,
    cri_r1_f8 integer DEFAULT 0,
    cri_r2_f8 integer DEFAULT 0,
    cri_r3_f8 integer DEFAULT 0,
    cri_r4_f8 integer DEFAULT 0,
    cri_r5_f8 integer DEFAULT 0,
    cri_r6_f8 integer DEFAULT 0,
    cri_r7_f8 integer DEFAULT 0,
    cri_r8_f8 integer DEFAULT 0,
    cri_r9_f8 integer DEFAULT 0,
    cri_r10_f8 integer DEFAULT 0,
    cri_r11_f8 integer DEFAULT 0,
    cri_r12_f8 integer DEFAULT 0,
    cri_r13_f8 integer DEFAULT 0,
    cri_r14_f8 integer DEFAULT 0,
    cri_r15_f8 integer DEFAULT 0,
    cri_r16_f8 integer DEFAULT 0,
    cri_r17_f8 integer DEFAULT 0,
    cri_r18_f8 integer DEFAULT 0,
    cri_r19_f8 integer DEFAULT 0,
    cri_r20_f8 integer DEFAULT 0,
    cri_r21_f8 integer DEFAULT 0,
    cri_r22_f8 integer DEFAULT 0,
    cri_r23_f8 integer DEFAULT 0,
    cri_r24_f8 integer DEFAULT 0,
    cri_r25_f8 integer DEFAULT 0,
    cri_r26_f8 integer DEFAULT 0,
    cri_r1_f9 integer DEFAULT 0,
    cri_r2_f9 integer DEFAULT 0,
    cri_r3_f9 integer DEFAULT 0,
    cri_r4_f9 integer DEFAULT 0,
    cri_r5_f9 integer DEFAULT 0,
    cri_r6_f9 integer DEFAULT 0,
    cri_r7_f9 integer DEFAULT 0,
    cri_r8_f9 integer DEFAULT 0,
    cri_r9_f9 integer DEFAULT 0,
    cri_r10_f9 integer DEFAULT 0,
    cri_r11_f9 integer DEFAULT 0,
    cri_r12_f9 integer DEFAULT 0,
    cri_r13_f9 integer DEFAULT 0,
    cri_r14_f9 integer DEFAULT 0,
    cri_r15_f9 integer DEFAULT 0,
    cri_r16_f9 integer DEFAULT 0,
    cri_r17_f9 integer DEFAULT 0,
    cri_r18_f9 integer DEFAULT 0,
    cri_r19_f9 integer DEFAULT 0,
    cri_r20_f9 integer DEFAULT 0,
    cri_r21_f9 integer DEFAULT 0,
    cri_r22_f9 integer DEFAULT 0,
    cri_r23_f9 integer DEFAULT 0,
    cri_r24_f9 integer DEFAULT 0,
    cri_r25_f9 integer DEFAULT 0,
    cri_r26_f9 integer DEFAULT 0,
    cri_r1_f10 integer DEFAULT 0,
    cri_r2_f10 integer DEFAULT 0,
    cri_r3_f10 integer DEFAULT 0,
    cri_r4_f10 integer DEFAULT 0,
    cri_r5_f10 integer DEFAULT 0,
    cri_r6_f10 integer DEFAULT 0,
    cri_r7_f10 integer DEFAULT 0,
    cri_r8_f10 integer DEFAULT 0,
    cri_r9_f10 integer DEFAULT 0,
    cri_r10_f10 integer DEFAULT 0,
    cri_r11_f10 integer DEFAULT 0,
    cri_r12_f10 integer DEFAULT 0,
    cri_r13_f10 integer DEFAULT 0,
    cri_r14_f10 integer DEFAULT 0,
    cri_r15_f10 integer DEFAULT 0,
    cri_r16_f10 integer DEFAULT 0,
    cri_r17_f10 integer DEFAULT 0,
    cri_r18_f10 integer DEFAULT 0,
    cri_r19_f10 integer DEFAULT 0,
    cri_r20_f10 integer DEFAULT 0,
    cri_r21_f10 integer DEFAULT 0,
    cri_r22_f10 integer DEFAULT 0,
    cri_r23_f10 integer DEFAULT 0,
    cri_r24_f10 integer DEFAULT 0,
    cri_r25_f10 integer DEFAULT 0,
    cri_r26_f10 integer DEFAULT 0,
    cri_r1_f11 integer DEFAULT 0,
    cri_r2_f11 integer DEFAULT 0,
    cri_r3_f11 integer DEFAULT 0,
    cri_r4_f11 integer DEFAULT 0,
    cri_r5_f11 integer DEFAULT 0,
    cri_r6_f11 integer DEFAULT 0,
    cri_r7_f11 integer DEFAULT 0,
    cri_r8_f11 integer DEFAULT 0,
    cri_r9_f11 integer DEFAULT 0,
    cri_r10_f11 integer DEFAULT 0,
    cri_r11_f11 integer DEFAULT 0,
    cri_r12_f11 integer DEFAULT 0,
    cri_r13_f11 integer DEFAULT 0,
    cri_r14_f11 integer DEFAULT 0,
    cri_r15_f11 integer DEFAULT 0,
    cri_r16_f11 integer DEFAULT 0,
    cri_r17_f11 integer DEFAULT 0,
    cri_r18_f11 integer DEFAULT 0,
    cri_r19_f11 integer DEFAULT 0,
    cri_r20_f11 integer DEFAULT 0,
    cri_r21_f11 integer DEFAULT 0,
    cri_r22_f11 integer DEFAULT 0,
    cri_r23_f11 integer DEFAULT 0,
    cri_r24_f11 integer DEFAULT 0,
    cri_r25_f11 integer DEFAULT 0,
    cri_r26_f11 integer DEFAULT 0,
    cri_r1_f12 integer DEFAULT 0,
    cri_r2_f12 integer DEFAULT 0,
    cri_r3_f12 integer DEFAULT 0,
    cri_r4_f12 integer DEFAULT 0,
    cri_r5_f12 integer DEFAULT 0,
    cri_r6_f12 integer DEFAULT 0,
    cri_r7_f12 integer DEFAULT 0,
    cri_r8_f12 integer DEFAULT 0,
    cri_r9_f12 integer DEFAULT 0,
    cri_r10_f12 integer DEFAULT 0,
    cri_r11_f12 integer DEFAULT 0,
    cri_r12_f12 integer DEFAULT 0,
    cri_r13_f12 integer DEFAULT 0,
    cri_r14_f12 integer DEFAULT 0,
    cri_r15_f12 integer DEFAULT 0,
    cri_r16_f12 integer DEFAULT 0,
    cri_r17_f12 integer DEFAULT 0,
    cri_r18_f12 integer DEFAULT 0,
    cri_r19_f12 integer DEFAULT 0,
    cri_r20_f12 integer DEFAULT 0,
    cri_r21_f12 integer DEFAULT 0,
    cri_r22_f12 integer DEFAULT 0,
    cri_r23_f12 integer DEFAULT 0,
    cri_r24_f12 integer DEFAULT 0,
    cri_r25_f12 integer DEFAULT 0,
    cri_r26_f12 integer DEFAULT 0,
    cri_r1_f13 integer DEFAULT 0,
    cri_r2_f13 integer DEFAULT 0,
    cri_r3_f13 integer DEFAULT 0,
    cri_r4_f13 integer DEFAULT 0,
    cri_r5_f13 integer DEFAULT 0,
    cri_r6_f13 integer DEFAULT 0,
    cri_r7_f13 integer DEFAULT 0,
    cri_r8_f13 integer DEFAULT 0,
    cri_r9_f13 integer DEFAULT 0,
    cri_r10_f13 integer DEFAULT 0,
    cri_r11_f13 integer DEFAULT 0,
    cri_r12_f13 integer DEFAULT 0,
    cri_r13_f13 integer DEFAULT 0,
    cri_r14_f13 integer DEFAULT 0,
    cri_r15_f13 integer DEFAULT 0,
    cri_r16_f13 integer DEFAULT 0,
    cri_r17_f13 integer DEFAULT 0,
    cri_r18_f13 integer DEFAULT 0,
    cri_r19_f13 integer DEFAULT 0,
    cri_r20_f13 integer DEFAULT 0,
    cri_r21_f13 integer DEFAULT 0,
    cri_r22_f13 integer DEFAULT 0,
    cri_r23_f13 integer DEFAULT 0,
    cri_r24_f13 integer DEFAULT 0,
    cri_r25_f13 integer DEFAULT 0,
    cri_r26_f13 integer DEFAULT 0,
    cri_r1_f14 integer DEFAULT 0,
    cri_r2_f14 integer DEFAULT 0,
    cri_r3_f14 integer DEFAULT 0,
    cri_r4_f14 integer DEFAULT 0,
    cri_r5_f14 integer DEFAULT 0,
    cri_r6_f14 integer DEFAULT 0,
    cri_r7_f14 integer DEFAULT 0,
    cri_r8_f14 integer DEFAULT 0,
    cri_r9_f14 integer DEFAULT 0,
    cri_r10_f14 integer DEFAULT 0,
    cri_r11_f14 integer DEFAULT 0,
    cri_r12_f14 integer DEFAULT 0,
    cri_r13_f14 integer DEFAULT 0,
    cri_r14_f14 integer DEFAULT 0,
    cri_r15_f14 integer DEFAULT 0,
    cri_r16_f14 integer DEFAULT 0,
    cri_r17_f14 integer DEFAULT 0,
    cri_r18_f14 integer DEFAULT 0,
    cri_r19_f14 integer DEFAULT 0,
    cri_r20_f14 integer DEFAULT 0,
    cri_r21_f14 integer DEFAULT 0,
    cri_r22_f14 integer DEFAULT 0,
    cri_r23_f14 integer DEFAULT 0,
    cri_r24_f14 integer DEFAULT 0,
    cri_r25_f14 integer DEFAULT 0,
    cri_r26_f14 integer DEFAULT 0,
    cri_r1_f15 integer DEFAULT 0,
    cri_r2_f15 integer DEFAULT 0,
    cri_r3_f15 integer DEFAULT 0,
    cri_r4_f15 integer DEFAULT 0,
    cri_r5_f15 integer DEFAULT 0,
    cri_r6_f15 integer DEFAULT 0,
    cri_r7_f15 integer DEFAULT 0,
    cri_r8_f15 integer DEFAULT 0,
    cri_r9_f15 integer DEFAULT 0,
    cri_r10_f15 integer DEFAULT 0,
    cri_r11_f15 integer DEFAULT 0,
    cri_r12_f15 integer DEFAULT 0,
    cri_r13_f15 integer DEFAULT 0,
    cri_r14_f15 integer DEFAULT 0,
    cri_r15_f15 integer DEFAULT 0,
    cri_r16_f15 integer DEFAULT 0,
    cri_r17_f15 integer DEFAULT 0,
    cri_r18_f15 integer DEFAULT 0,
    cri_r19_f15 integer DEFAULT 0,
    cri_r20_f15 integer DEFAULT 0,
    cri_r21_f15 integer DEFAULT 0,
    cri_r22_f15 integer DEFAULT 0,
    cri_r23_f15 integer DEFAULT 0,
    cri_r24_f15 integer DEFAULT 0,
    cri_r25_f15 integer DEFAULT 0,
    cri_r26_f15 integer DEFAULT 0,
    cri_r1_f16 integer DEFAULT 0,
    cri_r2_f16 integer DEFAULT 0,
    cri_r3_f16 integer DEFAULT 0,
    cri_r4_f16 integer DEFAULT 0,
    cri_r5_f16 integer DEFAULT 0,
    cri_r6_f16 integer DEFAULT 0,
    cri_r7_f16 integer DEFAULT 0,
    cri_r8_f16 integer DEFAULT 0,
    cri_r9_f16 integer DEFAULT 0,
    cri_r10_f16 integer DEFAULT 0,
    cri_r11_f16 integer DEFAULT 0,
    cri_r12_f16 integer DEFAULT 0,
    cri_r13_f16 integer DEFAULT 0,
    cri_r14_f16 integer DEFAULT 0,
    cri_r15_f16 integer DEFAULT 0,
    cri_r16_f16 integer DEFAULT 0,
    cri_r17_f16 integer DEFAULT 0,
    cri_r18_f16 integer DEFAULT 0,
    cri_r19_f16 integer DEFAULT 0,
    cri_r20_f16 integer DEFAULT 0,
    cri_r21_f16 integer DEFAULT 0,
    cri_r22_f16 integer DEFAULT 0,
    cri_r23_f16 integer DEFAULT 0,
    cri_r24_f16 integer DEFAULT 0,
    cri_r25_f16 integer DEFAULT 0,
    cri_r26_f16 integer DEFAULT 0,
    cri_r1_f17 integer DEFAULT 0,
    cri_r2_f17 integer DEFAULT 0,
    cri_r3_f17 integer DEFAULT 0,
    cri_r4_f17 integer DEFAULT 0,
    cri_r5_f17 integer DEFAULT 0,
    cri_r6_f17 integer DEFAULT 0,
    cri_r7_f17 integer DEFAULT 0,
    cri_r8_f17 integer DEFAULT 0,
    cri_r9_f17 integer DEFAULT 0,
    cri_r10_f17 integer DEFAULT 0,
    cri_r11_f17 integer DEFAULT 0,
    cri_r12_f17 integer DEFAULT 0,
    cri_r13_f17 integer DEFAULT 0,
    cri_r14_f17 integer DEFAULT 0,
    cri_r15_f17 integer DEFAULT 0,
    cri_r16_f17 integer DEFAULT 0,
    cri_r17_f17 integer DEFAULT 0,
    cri_r18_f17 integer DEFAULT 0,
    cri_r19_f17 integer DEFAULT 0,
    cri_r20_f17 integer DEFAULT 0,
    cri_r21_f17 integer DEFAULT 0,
    cri_r22_f17 integer DEFAULT 0,
    cri_r23_f17 integer DEFAULT 0,
    cri_r24_f17 integer DEFAULT 0,
    cri_r25_f17 integer DEFAULT 0,
    cri_r26_f17 integer DEFAULT 0,
    cri_r1_f18 integer DEFAULT 0,
    cri_r2_f18 integer DEFAULT 0,
    cri_r3_f18 integer DEFAULT 0,
    cri_r4_f18 integer DEFAULT 0,
    cri_r5_f18 integer DEFAULT 0,
    cri_r6_f18 integer DEFAULT 0,
    cri_r7_f18 integer DEFAULT 0,
    cri_r8_f18 integer DEFAULT 0,
    cri_r9_f18 integer DEFAULT 0,
    cri_r10_f18 integer DEFAULT 0,
    cri_r11_f18 integer DEFAULT 0,
    cri_r12_f18 integer DEFAULT 0,
    cri_r13_f18 integer DEFAULT 0,
    cri_r14_f18 integer DEFAULT 0,
    cri_r15_f18 integer DEFAULT 0,
    cri_r16_f18 integer DEFAULT 0,
    cri_r17_f18 integer DEFAULT 0,
    cri_r18_f18 integer DEFAULT 0,
    cri_r19_f18 integer DEFAULT 0,
    cri_r20_f18 integer DEFAULT 0,
    cri_r21_f18 integer DEFAULT 0,
    cri_r22_f18 integer DEFAULT 0,
    cri_r23_f18 integer DEFAULT 0,
    cri_r24_f18 integer DEFAULT 0,
    cri_r25_f18 integer DEFAULT 0,
    cri_r26_f18 integer DEFAULT 0,
    ttri_r1_f1 integer DEFAULT 0,
    ttri_r2_f1 integer DEFAULT 0,
    ttri_r3_f1 integer DEFAULT 0,
    ttri_r4_f1 integer DEFAULT 0,
    ttri_r5_f1 integer DEFAULT 0,
    ttri_r6_f1 integer DEFAULT 0,
    ttri_r7_f1 integer DEFAULT 0,
    ttri_r8_f1 integer DEFAULT 0,
    ttri_r9_f1 integer DEFAULT 0,
    ttri_r10_f1 integer DEFAULT 0,
    ttri_r1_f2 integer DEFAULT 0,
    ttri_r2_f2 integer DEFAULT 0,
    ttri_r3_f2 integer DEFAULT 0,
    ttri_r4_f2 integer DEFAULT 0,
    ttri_r5_f2 integer DEFAULT 0,
    ttri_r6_f2 integer DEFAULT 0,
    ttri_r7_f2 integer DEFAULT 0,
    ttri_r8_f2 integer DEFAULT 0,
    ttri_r9_f2 integer DEFAULT 0,
    ttri_r10_f2 integer DEFAULT 0,
    ttri_r1_f3 integer DEFAULT 0,
    ttri_r2_f3 integer DEFAULT 0,
    ttri_r3_f3 integer DEFAULT 0,
    ttri_r4_f3 integer DEFAULT 0,
    ttri_r5_f3 integer DEFAULT 0,
    ttri_r6_f3 integer DEFAULT 0,
    ttri_r7_f3 integer DEFAULT 0,
    ttri_r8_f3 integer DEFAULT 0,
    ttri_r9_f3 integer DEFAULT 0,
    ttri_r10_f3 integer DEFAULT 0,
    ttri_r1_f4 integer DEFAULT 0,
    ttri_r2_f4 integer DEFAULT 0,
    ttri_r3_f4 integer DEFAULT 0,
    ttri_r4_f4 integer DEFAULT 0,
    ttri_r5_f4 integer DEFAULT 0,
    ttri_r6_f4 integer DEFAULT 0,
    ttri_r7_f4 integer DEFAULT 0,
    ttri_r8_f4 integer DEFAULT 0,
    ttri_r9_f4 integer DEFAULT 0,
    ttri_r10_f4 integer DEFAULT 0,
    ttri_r1_f5 integer DEFAULT 0,
    ttri_r2_f5 integer DEFAULT 0,
    ttri_r3_f5 integer DEFAULT 0,
    ttri_r4_f5 integer DEFAULT 0,
    ttri_r5_f5 integer DEFAULT 0,
    ttri_r6_f5 integer DEFAULT 0,
    ttri_r7_f5 integer DEFAULT 0,
    ttri_r8_f5 integer DEFAULT 0,
    ttri_r9_f5 integer DEFAULT 0,
    ttri_r10_f5 integer DEFAULT 0,
    ttri_r1_f6 integer DEFAULT 0,
    ttri_r2_f6 integer DEFAULT 0,
    ttri_r3_f6 integer DEFAULT 0,
    ttri_r4_f6 integer DEFAULT 0,
    ttri_r5_f6 integer DEFAULT 0,
    ttri_r6_f6 integer DEFAULT 0,
    ttri_r7_f6 integer DEFAULT 0,
    ttri_r8_f6 integer DEFAULT 0,
    ttri_r9_f6 integer DEFAULT 0,
    ttri_r10_f6 integer DEFAULT 0,
    submitted_date date,
    vacc_name text,
    lhsname character varying(50),
    incharge_name text,
    techniciancode character varying(9),
    editted_date date,
    oui_r1_f1 integer DEFAULT 0,
    oui_r1_f2 integer DEFAULT 0,
    oui_r1_f3 integer DEFAULT 0,
    oui_r1_f4 integer DEFAULT 0,
    oui_r1_f5 integer DEFAULT 0,
    oui_r1_f6 integer DEFAULT 0,
    oui_r1_f7 integer DEFAULT 0,
    oui_r1_f8 integer DEFAULT 0,
    oui_r1_f9 integer DEFAULT 0,
    oui_r1_f10 integer DEFAULT 0,
    oui_r1_f11 integer DEFAULT 0,
    oui_r1_f12 integer DEFAULT 0,
    oui_r1_f13 integer DEFAULT 0,
    oui_r1_f14 integer DEFAULT 0,
    oui_r1_f15 integer DEFAULT 0,
    oui_r1_f16 integer DEFAULT 0,
    oui_r1_f17 integer DEFAULT 0,
    oui_r1_f18 integer DEFAULT 0,
    oui_r2_f1 integer DEFAULT 0,
    oui_r2_f2 integer DEFAULT 0,
    oui_r2_f3 integer DEFAULT 0,
    oui_r2_f4 integer DEFAULT 0,
    oui_r2_f5 integer DEFAULT 0,
    oui_r2_f6 integer DEFAULT 0,
    oui_r2_f7 integer DEFAULT 0,
    oui_r2_f8 integer DEFAULT 0,
    oui_r2_f9 integer DEFAULT 0,
    oui_r2_f10 integer DEFAULT 0,
    oui_r2_f11 integer DEFAULT 0,
    oui_r2_f12 integer DEFAULT 0,
    oui_r2_f13 integer DEFAULT 0,
    oui_r2_f14 integer DEFAULT 0,
    oui_r2_f15 integer DEFAULT 0,
    oui_r2_f16 integer DEFAULT 0,
    oui_r2_f17 integer DEFAULT 0,
    oui_r2_f18 integer DEFAULT 0,
    oui_r3_f1 integer DEFAULT 0,
    oui_r3_f2 integer DEFAULT 0,
    oui_r3_f3 integer DEFAULT 0,
    oui_r3_f4 integer DEFAULT 0,
    oui_r3_f5 integer DEFAULT 0,
    oui_r3_f6 integer DEFAULT 0,
    oui_r3_f7 integer DEFAULT 0,
    oui_r3_f8 integer DEFAULT 0,
    oui_r3_f9 integer DEFAULT 0,
    oui_r3_f10 integer DEFAULT 0,
    oui_r3_f11 integer DEFAULT 0,
    oui_r3_f12 integer DEFAULT 0,
    oui_r3_f13 integer DEFAULT 0,
    oui_r3_f14 integer DEFAULT 0,
    oui_r3_f15 integer DEFAULT 0,
    oui_r3_f16 integer DEFAULT 0,
    oui_r3_f17 integer DEFAULT 0,
    oui_r3_f18 integer DEFAULT 0,
    oui_r4_f1 integer DEFAULT 0,
    oui_r4_f2 integer DEFAULT 0,
    oui_r4_f3 integer DEFAULT 0,
    oui_r4_f4 integer DEFAULT 0,
    oui_r4_f5 integer DEFAULT 0,
    oui_r4_f6 integer DEFAULT 0,
    oui_r4_f7 integer DEFAULT 0,
    oui_r4_f8 integer DEFAULT 0,
    oui_r4_f9 integer DEFAULT 0,
    oui_r4_f10 integer DEFAULT 0,
    oui_r4_f11 integer DEFAULT 0,
    oui_r4_f12 integer DEFAULT 0,
    oui_r4_f13 integer DEFAULT 0,
    oui_r4_f14 integer DEFAULT 0,
    oui_r4_f15 integer DEFAULT 0,
    oui_r4_f16 integer DEFAULT 0,
    oui_r4_f17 integer DEFAULT 0,
    oui_r4_f18 integer DEFAULT 0,
    oui_r5_f1 integer DEFAULT 0,
    oui_r5_f2 integer DEFAULT 0,
    oui_r5_f3 integer DEFAULT 0,
    oui_r5_f4 integer DEFAULT 0,
    oui_r5_f5 integer DEFAULT 0,
    oui_r5_f6 integer DEFAULT 0,
    oui_r5_f7 integer DEFAULT 0,
    oui_r5_f8 integer DEFAULT 0,
    oui_r5_f9 integer DEFAULT 0,
    oui_r5_f10 integer DEFAULT 0,
    oui_r5_f11 integer DEFAULT 0,
    oui_r5_f12 integer DEFAULT 0,
    oui_r5_f13 integer DEFAULT 0,
    oui_r5_f14 integer DEFAULT 0,
    oui_r5_f15 integer DEFAULT 0,
    oui_r5_f16 integer DEFAULT 0,
    oui_r5_f17 integer DEFAULT 0,
    oui_r5_f18 integer DEFAULT 0,
    oui_r6_f1 integer DEFAULT 0,
    oui_r6_f2 integer DEFAULT 0,
    oui_r6_f3 integer DEFAULT 0,
    oui_r6_f4 integer DEFAULT 0,
    oui_r6_f5 integer DEFAULT 0,
    oui_r6_f6 integer DEFAULT 0,
    oui_r6_f7 integer DEFAULT 0,
    oui_r6_f8 integer DEFAULT 0,
    oui_r6_f9 integer DEFAULT 0,
    oui_r6_f10 integer DEFAULT 0,
    oui_r6_f11 integer DEFAULT 0,
    oui_r6_f12 integer DEFAULT 0,
    oui_r6_f13 integer DEFAULT 0,
    oui_r6_f14 integer DEFAULT 0,
    oui_r6_f15 integer DEFAULT 0,
    oui_r6_f16 integer DEFAULT 0,
    oui_r6_f17 integer DEFAULT 0,
    oui_r6_f18 integer DEFAULT 0,
    oui_r7_f1 integer DEFAULT 0,
    oui_r7_f2 integer DEFAULT 0,
    oui_r7_f3 integer DEFAULT 0,
    oui_r7_f4 integer DEFAULT 0,
    oui_r7_f5 integer DEFAULT 0,
    oui_r7_f6 integer DEFAULT 0,
    oui_r7_f7 integer DEFAULT 0,
    oui_r7_f8 integer DEFAULT 0,
    oui_r7_f9 integer DEFAULT 0,
    oui_r7_f10 integer DEFAULT 0,
    oui_r7_f11 integer DEFAULT 0,
    oui_r7_f12 integer DEFAULT 0,
    oui_r7_f13 integer DEFAULT 0,
    oui_r7_f14 integer DEFAULT 0,
    oui_r7_f15 integer DEFAULT 0,
    oui_r7_f16 integer DEFAULT 0,
    oui_r7_f17 integer DEFAULT 0,
    oui_r7_f18 integer DEFAULT 0,
    oui_r8_f1 integer DEFAULT 0,
    oui_r8_f2 integer DEFAULT 0,
    oui_r8_f3 integer DEFAULT 0,
    oui_r8_f4 integer DEFAULT 0,
    oui_r8_f5 integer DEFAULT 0,
    oui_r8_f6 integer DEFAULT 0,
    oui_r8_f7 integer DEFAULT 0,
    oui_r8_f8 integer DEFAULT 0,
    oui_r8_f9 integer DEFAULT 0,
    oui_r8_f10 integer DEFAULT 0,
    oui_r8_f11 integer DEFAULT 0,
    oui_r8_f12 integer DEFAULT 0,
    oui_r8_f13 integer DEFAULT 0,
    oui_r8_f14 integer DEFAULT 0,
    oui_r8_f15 integer DEFAULT 0,
    oui_r8_f16 integer DEFAULT 0,
    oui_r8_f17 integer DEFAULT 0,
    oui_r8_f18 integer DEFAULT 0,
    oui_r9_f1 integer DEFAULT 0,
    oui_r9_f2 integer DEFAULT 0,
    oui_r9_f3 integer DEFAULT 0,
    oui_r9_f4 integer DEFAULT 0,
    oui_r9_f5 integer DEFAULT 0,
    oui_r9_f6 integer DEFAULT 0,
    oui_r9_f7 integer DEFAULT 0,
    oui_r9_f8 integer DEFAULT 0,
    oui_r9_f9 integer DEFAULT 0,
    oui_r9_f10 integer DEFAULT 0,
    oui_r9_f11 integer DEFAULT 0,
    oui_r9_f12 integer DEFAULT 0,
    oui_r9_f13 integer DEFAULT 0,
    oui_r9_f14 integer DEFAULT 0,
    oui_r9_f15 integer DEFAULT 0,
    oui_r9_f16 integer DEFAULT 0,
    oui_r9_f17 integer DEFAULT 0,
    oui_r9_f18 integer DEFAULT 0,
    oui_r10_f1 integer DEFAULT 0,
    oui_r10_f2 integer DEFAULT 0,
    oui_r10_f3 integer DEFAULT 0,
    oui_r10_f4 integer DEFAULT 0,
    oui_r10_f5 integer DEFAULT 0,
    oui_r10_f6 integer DEFAULT 0,
    oui_r10_f7 integer DEFAULT 0,
    oui_r10_f8 integer DEFAULT 0,
    oui_r10_f9 integer DEFAULT 0,
    oui_r10_f10 integer DEFAULT 0,
    oui_r10_f11 integer DEFAULT 0,
    oui_r10_f12 integer DEFAULT 0,
    oui_r10_f13 integer DEFAULT 0,
    oui_r10_f14 integer DEFAULT 0,
    oui_r10_f15 integer DEFAULT 0,
    oui_r10_f16 integer DEFAULT 0,
    oui_r10_f17 integer DEFAULT 0,
    oui_r10_f18 integer DEFAULT 0,
    oui_r11_f1 integer DEFAULT 0,
    oui_r11_f2 integer DEFAULT 0,
    oui_r11_f3 integer DEFAULT 0,
    oui_r11_f4 integer DEFAULT 0,
    oui_r11_f5 integer DEFAULT 0,
    oui_r11_f6 integer DEFAULT 0,
    oui_r11_f7 integer DEFAULT 0,
    oui_r11_f8 integer DEFAULT 0,
    oui_r11_f9 integer DEFAULT 0,
    oui_r11_f10 integer DEFAULT 0,
    oui_r11_f11 integer DEFAULT 0,
    oui_r11_f12 integer DEFAULT 0,
    oui_r11_f13 integer DEFAULT 0,
    oui_r11_f14 integer DEFAULT 0,
    oui_r11_f15 integer DEFAULT 0,
    oui_r11_f16 integer DEFAULT 0,
    oui_r11_f17 integer DEFAULT 0,
    oui_r11_f18 integer DEFAULT 0,
    oui_r12_f1 integer DEFAULT 0,
    oui_r12_f2 integer DEFAULT 0,
    oui_r12_f3 integer DEFAULT 0,
    oui_r12_f4 integer DEFAULT 0,
    oui_r12_f5 integer DEFAULT 0,
    oui_r12_f6 integer DEFAULT 0,
    oui_r12_f7 integer DEFAULT 0,
    oui_r12_f8 integer DEFAULT 0,
    oui_r12_f9 integer DEFAULT 0,
    oui_r12_f10 integer DEFAULT 0,
    oui_r12_f11 integer DEFAULT 0,
    oui_r12_f12 integer DEFAULT 0,
    oui_r12_f13 integer DEFAULT 0,
    oui_r12_f14 integer DEFAULT 0,
    oui_r12_f15 integer DEFAULT 0,
    oui_r12_f16 integer DEFAULT 0,
    oui_r12_f17 integer DEFAULT 0,
    oui_r12_f18 integer DEFAULT 0,
    oui_r13_f1 integer DEFAULT 0,
    oui_r13_f2 integer DEFAULT 0,
    oui_r13_f3 integer DEFAULT 0,
    oui_r13_f4 integer DEFAULT 0,
    oui_r13_f5 integer DEFAULT 0,
    oui_r13_f6 integer DEFAULT 0,
    oui_r13_f7 integer DEFAULT 0,
    oui_r13_f8 integer DEFAULT 0,
    oui_r13_f9 integer DEFAULT 0,
    oui_r13_f10 integer DEFAULT 0,
    oui_r13_f11 integer DEFAULT 0,
    oui_r13_f12 integer DEFAULT 0,
    oui_r13_f13 integer DEFAULT 0,
    oui_r13_f14 integer DEFAULT 0,
    oui_r13_f15 integer DEFAULT 0,
    oui_r13_f16 integer DEFAULT 0,
    oui_r13_f17 integer DEFAULT 0,
    oui_r13_f18 integer DEFAULT 0,
    oui_r14_f1 integer DEFAULT 0,
    oui_r14_f2 integer DEFAULT 0,
    oui_r14_f3 integer DEFAULT 0,
    oui_r14_f4 integer DEFAULT 0,
    oui_r14_f5 integer DEFAULT 0,
    oui_r14_f6 integer DEFAULT 0,
    oui_r14_f7 integer DEFAULT 0,
    oui_r14_f8 integer DEFAULT 0,
    oui_r14_f9 integer DEFAULT 0,
    oui_r14_f10 integer DEFAULT 0,
    oui_r14_f11 integer DEFAULT 0,
    oui_r14_f12 integer DEFAULT 0,
    oui_r14_f13 integer DEFAULT 0,
    oui_r14_f14 integer DEFAULT 0,
    oui_r14_f15 integer DEFAULT 0,
    oui_r14_f16 integer DEFAULT 0,
    oui_r14_f17 integer DEFAULT 0,
    oui_r14_f18 integer DEFAULT 0,
    oui_r15_f1 integer DEFAULT 0,
    oui_r15_f2 integer DEFAULT 0,
    oui_r15_f3 integer DEFAULT 0,
    oui_r15_f4 integer DEFAULT 0,
    oui_r15_f5 integer DEFAULT 0,
    oui_r15_f6 integer DEFAULT 0,
    oui_r15_f7 integer DEFAULT 0,
    oui_r15_f8 integer DEFAULT 0,
    oui_r15_f9 integer DEFAULT 0,
    oui_r15_f10 integer DEFAULT 0,
    oui_r15_f11 integer DEFAULT 0,
    oui_r15_f12 integer DEFAULT 0,
    oui_r15_f13 integer DEFAULT 0,
    oui_r15_f14 integer DEFAULT 0,
    oui_r15_f15 integer DEFAULT 0,
    oui_r15_f16 integer DEFAULT 0,
    oui_r15_f17 integer DEFAULT 0,
    oui_r15_f18 integer DEFAULT 0,
    oui_r16_f1 integer DEFAULT 0,
    oui_r16_f2 integer DEFAULT 0,
    oui_r16_f3 integer DEFAULT 0,
    oui_r16_f4 integer DEFAULT 0,
    oui_r16_f5 integer DEFAULT 0,
    oui_r16_f6 integer DEFAULT 0,
    oui_r16_f7 integer DEFAULT 0,
    oui_r16_f8 integer DEFAULT 0,
    oui_r16_f9 integer DEFAULT 0,
    oui_r16_f10 integer DEFAULT 0,
    oui_r16_f11 integer DEFAULT 0,
    oui_r16_f12 integer DEFAULT 0,
    oui_r16_f13 integer DEFAULT 0,
    oui_r16_f14 integer DEFAULT 0,
    oui_r16_f15 integer DEFAULT 0,
    oui_r16_f16 integer DEFAULT 0,
    oui_r16_f17 integer DEFAULT 0,
    oui_r16_f18 integer DEFAULT 0,
    oui_r17_f1 integer DEFAULT 0,
    oui_r17_f2 integer DEFAULT 0,
    oui_r17_f3 integer DEFAULT 0,
    oui_r17_f4 integer DEFAULT 0,
    oui_r17_f5 integer DEFAULT 0,
    oui_r17_f6 integer DEFAULT 0,
    oui_r17_f7 integer DEFAULT 0,
    oui_r17_f8 integer DEFAULT 0,
    oui_r17_f9 integer DEFAULT 0,
    oui_r17_f10 integer DEFAULT 0,
    oui_r17_f11 integer DEFAULT 0,
    oui_r17_f12 integer DEFAULT 0,
    oui_r17_f13 integer DEFAULT 0,
    oui_r17_f14 integer DEFAULT 0,
    oui_r17_f15 integer DEFAULT 0,
    oui_r17_f16 integer DEFAULT 0,
    oui_r17_f17 integer DEFAULT 0,
    oui_r17_f18 integer DEFAULT 0,
    oui_r18_f1 integer DEFAULT 0,
    oui_r18_f2 integer DEFAULT 0,
    oui_r18_f3 integer DEFAULT 0,
    oui_r18_f4 integer DEFAULT 0,
    oui_r18_f5 integer DEFAULT 0,
    oui_r18_f6 integer DEFAULT 0,
    oui_r18_f7 integer DEFAULT 0,
    oui_r18_f8 integer DEFAULT 0,
    oui_r18_f9 integer DEFAULT 0,
    oui_r18_f10 integer DEFAULT 0,
    oui_r18_f11 integer DEFAULT 0,
    oui_r18_f12 integer DEFAULT 0,
    oui_r18_f13 integer DEFAULT 0,
    oui_r18_f14 integer DEFAULT 0,
    oui_r18_f15 integer DEFAULT 0,
    oui_r18_f16 integer DEFAULT 0,
    oui_r18_f17 integer DEFAULT 0,
    oui_r18_f18 integer DEFAULT 0,
    oui_r19_f1 integer DEFAULT 0,
    oui_r19_f2 integer DEFAULT 0,
    oui_r19_f3 integer DEFAULT 0,
    oui_r19_f4 integer DEFAULT 0,
    oui_r19_f5 integer DEFAULT 0,
    oui_r19_f6 integer DEFAULT 0,
    oui_r19_f7 integer DEFAULT 0,
    oui_r19_f8 integer DEFAULT 0,
    oui_r19_f9 integer DEFAULT 0,
    oui_r19_f10 integer DEFAULT 0,
    oui_r19_f11 integer DEFAULT 0,
    oui_r19_f12 integer DEFAULT 0,
    oui_r19_f13 integer DEFAULT 0,
    oui_r19_f14 integer DEFAULT 0,
    oui_r19_f15 integer DEFAULT 0,
    oui_r19_f16 integer DEFAULT 0,
    oui_r19_f17 integer DEFAULT 0,
    oui_r19_f18 integer DEFAULT 0,
    oui_r20_f1 integer DEFAULT 0,
    oui_r20_f2 integer DEFAULT 0,
    oui_r20_f3 integer DEFAULT 0,
    oui_r20_f4 integer DEFAULT 0,
    oui_r20_f5 integer DEFAULT 0,
    oui_r20_f6 integer DEFAULT 0,
    oui_r20_f7 integer DEFAULT 0,
    oui_r20_f8 integer DEFAULT 0,
    oui_r20_f9 integer DEFAULT 0,
    oui_r20_f10 integer DEFAULT 0,
    oui_r20_f11 integer DEFAULT 0,
    oui_r20_f12 integer DEFAULT 0,
    oui_r20_f13 integer DEFAULT 0,
    oui_r20_f14 integer DEFAULT 0,
    oui_r20_f15 integer DEFAULT 0,
    oui_r20_f16 integer DEFAULT 0,
    oui_r20_f17 integer DEFAULT 0,
    oui_r20_f18 integer DEFAULT 0,
    oui_r21_f1 integer DEFAULT 0,
    oui_r21_f2 integer DEFAULT 0,
    oui_r21_f3 integer DEFAULT 0,
    oui_r21_f4 integer DEFAULT 0,
    oui_r21_f5 integer DEFAULT 0,
    oui_r21_f6 integer DEFAULT 0,
    oui_r21_f7 integer DEFAULT 0,
    oui_r21_f8 integer DEFAULT 0,
    oui_r21_f9 integer DEFAULT 0,
    oui_r21_f10 integer DEFAULT 0,
    oui_r21_f11 integer DEFAULT 0,
    oui_r21_f12 integer DEFAULT 0,
    oui_r21_f13 integer DEFAULT 0,
    oui_r21_f14 integer DEFAULT 0,
    oui_r21_f15 integer DEFAULT 0,
    oui_r21_f16 integer DEFAULT 0,
    oui_r21_f17 integer DEFAULT 0,
    oui_r21_f18 integer DEFAULT 0,
    oui_r22_f1 integer DEFAULT 0,
    oui_r22_f2 integer DEFAULT 0,
    oui_r22_f3 integer DEFAULT 0,
    oui_r22_f4 integer DEFAULT 0,
    oui_r22_f5 integer DEFAULT 0,
    oui_r22_f6 integer DEFAULT 0,
    oui_r22_f7 integer DEFAULT 0,
    oui_r22_f8 integer DEFAULT 0,
    oui_r22_f9 integer DEFAULT 0,
    oui_r22_f10 integer DEFAULT 0,
    oui_r22_f11 integer DEFAULT 0,
    oui_r22_f12 integer DEFAULT 0,
    oui_r22_f13 integer DEFAULT 0,
    oui_r22_f14 integer DEFAULT 0,
    oui_r22_f15 integer DEFAULT 0,
    oui_r22_f16 integer DEFAULT 0,
    oui_r22_f17 integer DEFAULT 0,
    oui_r22_f18 integer DEFAULT 0,
    oui_r23_f1 integer DEFAULT 0,
    oui_r23_f2 integer DEFAULT 0,
    oui_r23_f3 integer DEFAULT 0,
    oui_r23_f4 integer DEFAULT 0,
    oui_r23_f5 integer DEFAULT 0,
    oui_r23_f6 integer DEFAULT 0,
    oui_r23_f7 integer DEFAULT 0,
    oui_r23_f8 integer DEFAULT 0,
    oui_r23_f9 integer DEFAULT 0,
    oui_r23_f10 integer DEFAULT 0,
    oui_r23_f11 integer DEFAULT 0,
    oui_r23_f12 integer DEFAULT 0,
    oui_r23_f13 integer DEFAULT 0,
    oui_r23_f14 integer DEFAULT 0,
    oui_r23_f15 integer DEFAULT 0,
    oui_r23_f16 integer DEFAULT 0,
    oui_r23_f17 integer DEFAULT 0,
    oui_r23_f18 integer DEFAULT 0,
    oui_r24_f1 integer DEFAULT 0,
    oui_r24_f2 integer DEFAULT 0,
    oui_r24_f3 integer DEFAULT 0,
    oui_r24_f4 integer DEFAULT 0,
    oui_r24_f5 integer DEFAULT 0,
    oui_r24_f6 integer DEFAULT 0,
    oui_r24_f7 integer DEFAULT 0,
    oui_r24_f8 integer DEFAULT 0,
    oui_r24_f9 integer DEFAULT 0,
    oui_r24_f10 integer DEFAULT 0,
    oui_r24_f11 integer DEFAULT 0,
    oui_r24_f12 integer DEFAULT 0,
    oui_r24_f13 integer DEFAULT 0,
    oui_r24_f14 integer DEFAULT 0,
    oui_r24_f15 integer DEFAULT 0,
    oui_r24_f16 integer DEFAULT 0,
    oui_r24_f17 integer DEFAULT 0,
    oui_r24_f18 integer DEFAULT 0,
    oui_r25_f1 integer DEFAULT 0,
    oui_r25_f2 integer DEFAULT 0,
    oui_r25_f3 integer DEFAULT 0,
    oui_r25_f4 integer DEFAULT 0,
    oui_r25_f5 integer DEFAULT 0,
    oui_r25_f6 integer DEFAULT 0,
    oui_r25_f7 integer DEFAULT 0,
    oui_r25_f8 integer DEFAULT 0,
    oui_r25_f9 integer DEFAULT 0,
    oui_r25_f10 integer DEFAULT 0,
    oui_r25_f11 integer DEFAULT 0,
    oui_r25_f12 integer DEFAULT 0,
    oui_r25_f13 integer DEFAULT 0,
    oui_r25_f14 integer DEFAULT 0,
    oui_r25_f15 integer DEFAULT 0,
    oui_r25_f16 integer DEFAULT 0,
    oui_r25_f17 integer DEFAULT 0,
    oui_r25_f18 integer DEFAULT 0,
    oui_r26_f1 integer DEFAULT 0,
    oui_r26_f2 integer DEFAULT 0,
    oui_r26_f3 integer DEFAULT 0,
    oui_r26_f4 integer DEFAULT 0,
    oui_r26_f5 integer DEFAULT 0,
    oui_r26_f6 integer DEFAULT 0,
    oui_r26_f7 integer DEFAULT 0,
    oui_r26_f8 integer DEFAULT 0,
    oui_r26_f9 integer DEFAULT 0,
    oui_r26_f10 integer DEFAULT 0,
    oui_r26_f11 integer DEFAULT 0,
    oui_r26_f12 integer DEFAULT 0,
    oui_r26_f13 integer DEFAULT 0,
    oui_r26_f14 integer DEFAULT 0,
    oui_r26_f15 integer DEFAULT 0,
    oui_r26_f16 integer DEFAULT 0,
    oui_r26_f17 integer DEFAULT 0,
    oui_r26_f18 integer DEFAULT 0,
    ttoui_r1_f1 integer DEFAULT 0,
    ttoui_r1_f2 integer DEFAULT 0,
    ttoui_r1_f3 integer DEFAULT 0,
    ttoui_r1_f4 integer DEFAULT 0,
    ttoui_r1_f5 integer DEFAULT 0,
    ttoui_r1_f6 integer DEFAULT 0,
    ttoui_r2_f1 integer DEFAULT 0,
    ttoui_r2_f2 integer DEFAULT 0,
    ttoui_r2_f3 integer DEFAULT 0,
    ttoui_r2_f4 integer DEFAULT 0,
    ttoui_r2_f5 integer DEFAULT 0,
    ttoui_r2_f6 integer DEFAULT 0,
    ttoui_r3_f1 integer DEFAULT 0,
    ttoui_r3_f2 integer DEFAULT 0,
    ttoui_r3_f3 integer DEFAULT 0,
    ttoui_r3_f4 integer DEFAULT 0,
    ttoui_r3_f5 integer DEFAULT 0,
    ttoui_r3_f6 integer DEFAULT 0,
    ttoui_r4_f1 integer DEFAULT 0,
    ttoui_r4_f2 integer DEFAULT 0,
    ttoui_r4_f3 integer DEFAULT 0,
    ttoui_r4_f4 integer DEFAULT 0,
    ttoui_r4_f5 integer DEFAULT 0,
    ttoui_r4_f6 integer DEFAULT 0,
    ttoui_r5_f1 integer DEFAULT 0,
    ttoui_r5_f2 integer DEFAULT 0,
    ttoui_r5_f3 integer DEFAULT 0,
    ttoui_r5_f4 integer DEFAULT 0,
    ttoui_r5_f5 integer DEFAULT 0,
    ttoui_r5_f6 integer DEFAULT 0,
    ttoui_r6_f1 integer DEFAULT 0,
    ttoui_r6_f2 integer DEFAULT 0,
    ttoui_r6_f3 integer DEFAULT 0,
    ttoui_r6_f4 integer DEFAULT 0,
    ttoui_r6_f5 integer DEFAULT 0,
    ttoui_r6_f6 integer DEFAULT 0,
    ttoui_r7_f1 integer DEFAULT 0,
    ttoui_r7_f2 integer DEFAULT 0,
    ttoui_r7_f3 integer DEFAULT 0,
    ttoui_r7_f4 integer DEFAULT 0,
    ttoui_r7_f5 integer DEFAULT 0,
    ttoui_r7_f6 integer DEFAULT 0,
    ttoui_r8_f1 integer DEFAULT 0,
    ttoui_r8_f2 integer DEFAULT 0,
    ttoui_r8_f3 integer DEFAULT 0,
    ttoui_r8_f4 integer DEFAULT 0,
    ttoui_r8_f5 integer DEFAULT 0,
    ttoui_r8_f6 integer DEFAULT 0,
    ttoui_r9_f1 integer DEFAULT 0,
    ttoui_r9_f2 integer DEFAULT 0,
    ttoui_r9_f3 integer DEFAULT 0,
    ttoui_r9_f4 integer DEFAULT 0,
    ttoui_r9_f5 integer DEFAULT 0,
    ttoui_r9_f6 integer DEFAULT 0,
    ttoui_r10_f1 integer DEFAULT 0,
    ttoui_r10_f2 integer DEFAULT 0,
    ttoui_r10_f3 integer DEFAULT 0,
    ttoui_r10_f4 integer DEFAULT 0,
    ttoui_r10_f5 integer DEFAULT 0,
    ttoui_r10_f6 integer DEFAULT 0,
    mv_vacc_planned integer DEFAULT 0,
    mv_vacc_held integer DEFAULT 0,
    cri_r27_f1 integer DEFAULT 0,
    cri_r28_f1 integer DEFAULT 0,
    cri_r29_f1 integer DEFAULT 0,
    cri_r30_f1 integer DEFAULT 0,
    cri_r31_f1 integer DEFAULT 0,
    cri_r32_f1 integer DEFAULT 0,
    cri_r27_f2 integer DEFAULT 0,
    cri_r28_f2 integer DEFAULT 0,
    cri_r29_f2 integer DEFAULT 0,
    cri_r30_f2 integer DEFAULT 0,
    cri_r31_f2 integer DEFAULT 0,
    cri_r32_f2 integer DEFAULT 0,
    cri_r27_f3 integer DEFAULT 0,
    cri_r28_f3 integer DEFAULT 0,
    cri_r29_f3 integer DEFAULT 0,
    cri_r30_f3 integer DEFAULT 0,
    cri_r31_f3 integer DEFAULT 0,
    cri_r32_f3 integer DEFAULT 0,
    cri_r27_f4 integer DEFAULT 0,
    cri_r28_f4 integer DEFAULT 0,
    cri_r29_f4 integer DEFAULT 0,
    cri_r30_f4 integer DEFAULT 0,
    cri_r31_f4 integer DEFAULT 0,
    cri_r32_f4 integer DEFAULT 0,
    cri_r27_f5 integer DEFAULT 0,
    cri_r28_f5 integer DEFAULT 0,
    cri_r29_f5 integer DEFAULT 0,
    cri_r30_f5 integer DEFAULT 0,
    cri_r31_f5 integer DEFAULT 0,
    cri_r32_f5 integer DEFAULT 0,
    cri_r27_f6 integer DEFAULT 0,
    cri_r28_f6 integer DEFAULT 0,
    cri_r29_f6 integer DEFAULT 0,
    cri_r30_f6 integer DEFAULT 0,
    cri_r31_f6 integer DEFAULT 0,
    cri_r32_f6 integer DEFAULT 0,
    cri_r27_f7 integer DEFAULT 0,
    cri_r28_f7 integer DEFAULT 0,
    cri_r29_f7 integer DEFAULT 0,
    cri_r30_f7 integer DEFAULT 0,
    cri_r31_f7 integer DEFAULT 0,
    cri_r32_f7 integer DEFAULT 0,
    cri_r27_f8 integer DEFAULT 0,
    cri_r28_f8 integer DEFAULT 0,
    cri_r29_f8 integer DEFAULT 0,
    cri_r30_f8 integer DEFAULT 0,
    cri_r31_f8 integer DEFAULT 0,
    cri_r32_f8 integer DEFAULT 0,
    cri_r27_f9 integer DEFAULT 0,
    cri_r28_f9 integer DEFAULT 0,
    cri_r29_f9 integer DEFAULT 0,
    cri_r30_f9 integer DEFAULT 0,
    cri_r31_f9 integer DEFAULT 0,
    cri_r32_f9 integer DEFAULT 0,
    cri_r27_f10 integer DEFAULT 0,
    cri_r28_f10 integer DEFAULT 0,
    cri_r29_f10 integer DEFAULT 0,
    cri_r30_f10 integer DEFAULT 0,
    cri_r31_f10 integer DEFAULT 0,
    cri_r32_f10 integer DEFAULT 0,
    cri_r27_f11 integer DEFAULT 0,
    cri_r28_f11 integer DEFAULT 0,
    cri_r29_f11 integer DEFAULT 0,
    cri_r30_f11 integer DEFAULT 0,
    cri_r31_f11 integer DEFAULT 0,
    cri_r32_f11 integer DEFAULT 0,
    cri_r27_f12 integer DEFAULT 0,
    cri_r28_f12 integer DEFAULT 0,
    cri_r29_f12 integer DEFAULT 0,
    cri_r30_f12 integer DEFAULT 0,
    cri_r31_f12 integer DEFAULT 0,
    cri_r32_f12 integer DEFAULT 0,
    cri_r27_f13 integer DEFAULT 0,
    cri_r28_f13 integer DEFAULT 0,
    cri_r29_f13 integer DEFAULT 0,
    cri_r30_f13 integer DEFAULT 0,
    cri_r31_f13 integer DEFAULT 0,
    cri_r32_f13 integer DEFAULT 0,
    cri_r27_f14 integer DEFAULT 0,
    cri_r28_f14 integer DEFAULT 0,
    cri_r29_f14 integer DEFAULT 0,
    cri_r30_f14 integer DEFAULT 0,
    cri_r31_f14 integer DEFAULT 0,
    cri_r32_f14 integer DEFAULT 0,
    cri_r27_f15 integer DEFAULT 0,
    cri_r28_f15 integer DEFAULT 0,
    cri_r29_f15 integer DEFAULT 0,
    cri_r30_f15 integer DEFAULT 0,
    cri_r31_f15 integer DEFAULT 0,
    cri_r32_f15 integer DEFAULT 0,
    cri_r27_f16 integer DEFAULT 0,
    cri_r28_f16 integer DEFAULT 0,
    cri_r29_f16 integer DEFAULT 0,
    cri_r30_f16 integer DEFAULT 0,
    cri_r31_f16 integer DEFAULT 0,
    cri_r32_f16 integer DEFAULT 0,
    cri_r27_f17 integer DEFAULT 0,
    cri_r28_f17 integer DEFAULT 0,
    cri_r29_f17 integer DEFAULT 0,
    cri_r30_f17 integer DEFAULT 0,
    cri_r31_f17 integer DEFAULT 0,
    cri_r32_f17 integer DEFAULT 0,
    cri_r27_f18 integer DEFAULT 0,
    cri_r28_f18 integer DEFAULT 0,
    cri_r29_f18 integer DEFAULT 0,
    cri_r30_f18 integer DEFAULT 0,
    cri_r31_f18 integer DEFAULT 0,
    cri_r32_f18 integer DEFAULT 0,
    cri_r25_f19 integer DEFAULT 0,
    cri_r26_f19 integer DEFAULT 0,
    cri_r1_f20 integer DEFAULT 0,
    cri_r2_f20 integer DEFAULT 0,
    cri_r3_f20 integer DEFAULT 0,
    cri_r4_f20 integer DEFAULT 0,
    cri_r5_f20 integer DEFAULT 0,
    cri_r6_f20 integer DEFAULT 0,
    cri_r7_f20 integer DEFAULT 0,
    cri_r8_f20 integer DEFAULT 0,
    cri_r9_f20 integer DEFAULT 0,
    cri_r10_f20 integer DEFAULT 0,
    cri_r11_f20 integer DEFAULT 0,
    cri_r12_f20 integer DEFAULT 0,
    cri_r13_f20 integer DEFAULT 0,
    cri_r14_f20 integer DEFAULT 0,
    cri_r15_f20 integer DEFAULT 0,
    cri_r16_f20 integer DEFAULT 0,
    cri_r17_f20 integer DEFAULT 0,
    cri_r18_f20 integer DEFAULT 0,
    cri_r19_f20 integer DEFAULT 0,
    cri_r20_f20 integer DEFAULT 0,
    cri_r21_f20 integer DEFAULT 0,
    cri_r22_f20 integer DEFAULT 0,
    cri_r23_f20 integer DEFAULT 0,
    cri_r24_f20 integer DEFAULT 0,
    cri_r25_f20 integer DEFAULT 0,
    cri_r26_f20 integer DEFAULT 0,
    cri_r1_f21 integer DEFAULT 0,
    cri_r2_f21 integer DEFAULT 0,
    cri_r3_f21 integer DEFAULT 0,
    cri_r4_f21 integer DEFAULT 0,
    cri_r5_f21 integer DEFAULT 0,
    cri_r6_f21 integer DEFAULT 0,
    cri_r7_f21 integer DEFAULT 0,
    cri_r8_f21 integer DEFAULT 0,
    cri_r9_f21 integer DEFAULT 0,
    cri_r10_f21 integer DEFAULT 0,
    cri_r11_f21 integer DEFAULT 0,
    cri_r12_f21 integer DEFAULT 0,
    cri_r13_f21 integer DEFAULT 0,
    cri_r14_f21 integer DEFAULT 0,
    cri_r15_f21 integer DEFAULT 0,
    cri_r16_f21 integer DEFAULT 0,
    cri_r17_f21 integer DEFAULT 0,
    cri_r18_f21 integer DEFAULT 0,
    cri_r19_f21 integer DEFAULT 0,
    cri_r20_f21 integer DEFAULT 0,
    cri_r21_f21 integer DEFAULT 0,
    cri_r22_f21 integer DEFAULT 0,
    cri_r23_f21 integer DEFAULT 0,
    cri_r24_f21 integer DEFAULT 0,
    cri_r25_f21 integer DEFAULT 0,
    cri_r26_f21 integer DEFAULT 0,
    oui_r1_f20 integer DEFAULT 0,
    oui_r2_f20 integer DEFAULT 0,
    oui_r3_f20 integer DEFAULT 0,
    oui_r4_f20 integer DEFAULT 0,
    oui_r5_f20 integer DEFAULT 0,
    oui_r6_f20 integer DEFAULT 0,
    oui_r7_f20 integer DEFAULT 0,
    oui_r8_f20 integer DEFAULT 0,
    oui_r9_f20 integer DEFAULT 0,
    oui_r10_f20 integer DEFAULT 0,
    oui_r11_f20 integer DEFAULT 0,
    oui_r12_f20 integer DEFAULT 0,
    oui_r13_f20 integer DEFAULT 0,
    oui_r14_f20 integer DEFAULT 0,
    oui_r15_f20 integer DEFAULT 0,
    oui_r16_f20 integer DEFAULT 0,
    oui_r17_f20 integer DEFAULT 0,
    oui_r18_f20 integer DEFAULT 0,
    oui_r19_f20 integer DEFAULT 0,
    oui_r20_f20 integer DEFAULT 0,
    oui_r21_f20 integer DEFAULT 0,
    oui_r22_f20 integer DEFAULT 0,
    oui_r23_f20 integer DEFAULT 0,
    oui_r24_f20 integer DEFAULT 0,
    oui_r25_f20 integer DEFAULT 0,
    oui_r26_f20 integer DEFAULT 0,
    oui_r1_f21 integer DEFAULT 0,
    oui_r2_f21 integer DEFAULT 0,
    oui_r3_f21 integer DEFAULT 0,
    oui_r4_f21 integer DEFAULT 0,
    oui_r5_f21 integer DEFAULT 0,
    oui_r6_f21 integer DEFAULT 0,
    oui_r7_f21 integer DEFAULT 0,
    oui_r8_f21 integer DEFAULT 0,
    oui_r9_f21 integer DEFAULT 0,
    oui_r10_f21 integer DEFAULT 0,
    oui_r11_f21 integer DEFAULT 0,
    oui_r12_f21 integer DEFAULT 0,
    oui_r13_f21 integer DEFAULT 0,
    oui_r14_f21 integer DEFAULT 0,
    oui_r15_f21 integer DEFAULT 0,
    oui_r16_f21 integer DEFAULT 0,
    oui_r17_f21 integer DEFAULT 0,
    oui_r18_f21 integer DEFAULT 0,
    oui_r19_f21 integer DEFAULT 0,
    oui_r20_f21 integer DEFAULT 0,
    oui_r21_f21 integer DEFAULT 0,
    oui_r22_f21 integer DEFAULT 0,
    oui_r23_f21 integer DEFAULT 0,
    oui_r24_f21 integer DEFAULT 0,
    oui_r25_f21 integer DEFAULT 0,
    oui_r26_f21 integer DEFAULT 0,
    cri_r27_f20 integer DEFAULT 0,
    cri_r28_f20 integer DEFAULT 0,
    cri_r29_f20 integer DEFAULT 0,
    cri_r30_f20 integer DEFAULT 0,
    cri_r31_f20 integer DEFAULT 0,
    cri_r32_f20 integer DEFAULT 0,
    cri_r27_f21 integer DEFAULT 0,
    cri_r28_f21 integer DEFAULT 0,
    cri_r29_f21 integer DEFAULT 0,
    cri_r30_f21 integer DEFAULT 0,
    cri_r31_f21 integer DEFAULT 0,
    cri_r32_f21 integer DEFAULT 0,
    cri_r1_f19 integer DEFAULT 0,
    cri_r2_f19 integer DEFAULT 0,
    cri_r3_f19 integer DEFAULT 0,
    cri_r4_f19 integer DEFAULT 0,
    cri_r5_f19 integer DEFAULT 0,
    cri_r6_f19 integer DEFAULT 0,
    cri_r7_f19 integer DEFAULT 0,
    cri_r8_f19 integer DEFAULT 0,
    cri_r9_f19 integer DEFAULT 0,
    cri_r10_f19 integer DEFAULT 0,
    cri_r11_f19 integer DEFAULT 0,
    cri_r12_f19 integer DEFAULT 0,
    cri_r13_f19 integer DEFAULT 0,
    cri_r14_f19 integer DEFAULT 0,
    cri_r15_f19 integer DEFAULT 0,
    cri_r16_f19 integer DEFAULT 0,
    cri_r17_f19 integer DEFAULT 0,
    cri_r18_f19 integer DEFAULT 0,
    cri_r19_f19 integer DEFAULT 0,
    cri_r20_f19 integer DEFAULT 0,
    cri_r21_f19 integer DEFAULT 0,
    cri_r22_f19 integer DEFAULT 0,
    cri_r23_f19 integer DEFAULT 0,
    cri_r24_f19 integer DEFAULT 0,
    oui_r1_f19 integer DEFAULT 0,
    oui_r2_f19 integer DEFAULT 0,
    oui_r3_f19 integer DEFAULT 0,
    oui_r4_f19 integer DEFAULT 0,
    oui_r5_f19 integer DEFAULT 0,
    oui_r6_f19 integer DEFAULT 0,
    oui_r7_f19 integer DEFAULT 0,
    oui_r8_f19 integer DEFAULT 0,
    oui_r9_f19 integer DEFAULT 0,
    oui_r10_f19 integer DEFAULT 0,
    oui_r11_f19 integer DEFAULT 0,
    oui_r12_f19 integer DEFAULT 0,
    oui_r13_f19 integer DEFAULT 0,
    oui_r14_f19 integer DEFAULT 0,
    oui_r15_f19 integer DEFAULT 0,
    oui_r16_f19 integer DEFAULT 0,
    oui_r17_f19 integer DEFAULT 0,
    oui_r18_f19 integer DEFAULT 0,
    oui_r19_f19 integer DEFAULT 0,
    oui_r20_f19 integer DEFAULT 0,
    oui_r21_f19 integer DEFAULT 0,
    oui_r22_f19 integer DEFAULT 0,
    oui_r23_f19 integer DEFAULT 0,
    oui_r24_f19 integer DEFAULT 0,
    oui_r25_f19 integer DEFAULT 0,
    oui_r26_f19 integer DEFAULT 0,
    cri_r27_f19 integer DEFAULT 0,
    cri_r28_f19 integer DEFAULT 0,
    cri_r29_f19 integer DEFAULT 0,
    cri_r30_f19 integer DEFAULT 0,
    cri_r31_f19 integer DEFAULT 0,
    cri_r32_f19 integer DEFAULT 0
);


ALTER TABLE public.fac_mvrf_db OWNER TO postgres;

--
-- Name: fac_mvrf_od_db; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE fac_mvrf_od_db (
    id integer DEFAULT nextval('fac_mvrf_db_id_seq'::regclass) NOT NULL,
    procode character varying(1) DEFAULT 3,
    distcode character varying(3) NOT NULL,
    facode character varying(6),
    tcode character varying(6) NOT NULL,
    uncode character varying(9),
    fmonth character varying(7),
    tc_male integer DEFAULT 0,
    tc_female integer DEFAULT 0,
    pw_monthly_target integer DEFAULT 0,
    tot_lhw_attached integer DEFAULT 0,
    tot_lhw_involved_vacc integer DEFAULT 0,
    tot_fixed_centers integer DEFAULT 0,
    functioning_centers integer DEFAULT 0,
    reporting_centers integer DEFAULT 0,
    fixed_vacc_planned integer DEFAULT 0,
    fixed_vacc_held integer DEFAULT 0,
    or_vacc_planned integer DEFAULT 0,
    or_vacc_held integer DEFAULT 0,
    hh_vacc_planned integer DEFAULT 0,
    hh_vacc_held integer DEFAULT 0,
    submitted_date date,
    vacc_name text,
    lhsname character varying(50),
    incharge_name text,
    techniciancode character varying(9),
    editted_date date,
    od_r1_f1 integer DEFAULT 0,
    od_r1_f2 integer DEFAULT 0,
    od_r1_f3 integer DEFAULT 0,
    od_r1_f4 integer DEFAULT 0,
    od_r1_f5 integer DEFAULT 0,
    od_r1_f6 integer DEFAULT 0,
    od_r1_f7 integer DEFAULT 0,
    od_r1_f8 integer DEFAULT 0,
    od_r1_f9 integer DEFAULT 0,
    od_r1_f10 integer DEFAULT 0,
    od_r1_f11 integer DEFAULT 0,
    od_r1_f12 integer DEFAULT 0,
    od_r1_f13 integer DEFAULT 0,
    od_r1_f14 integer DEFAULT 0,
    od_r1_f15 integer DEFAULT 0,
    od_r1_f16 integer DEFAULT 0,
    od_r1_f17 integer DEFAULT 0,
    od_r1_f18 integer DEFAULT 0,
    od_r2_f1 integer DEFAULT 0,
    od_r2_f2 integer DEFAULT 0,
    od_r2_f3 integer DEFAULT 0,
    od_r2_f4 integer DEFAULT 0,
    od_r2_f5 integer DEFAULT 0,
    od_r2_f6 integer DEFAULT 0,
    od_r2_f7 integer DEFAULT 0,
    od_r2_f8 integer DEFAULT 0,
    od_r2_f9 integer DEFAULT 0,
    od_r2_f10 integer DEFAULT 0,
    od_r2_f11 integer DEFAULT 0,
    od_r2_f12 integer DEFAULT 0,
    od_r2_f13 integer DEFAULT 0,
    od_r2_f14 integer DEFAULT 0,
    od_r2_f15 integer DEFAULT 0,
    od_r2_f16 integer DEFAULT 0,
    od_r2_f17 integer DEFAULT 0,
    od_r2_f18 integer DEFAULT 0,
    od_r3_f1 integer DEFAULT 0,
    od_r3_f2 integer DEFAULT 0,
    od_r3_f3 integer DEFAULT 0,
    od_r3_f4 integer DEFAULT 0,
    od_r3_f5 integer DEFAULT 0,
    od_r3_f6 integer DEFAULT 0,
    od_r3_f7 integer DEFAULT 0,
    od_r3_f8 integer DEFAULT 0,
    od_r3_f9 integer DEFAULT 0,
    od_r3_f10 integer DEFAULT 0,
    od_r3_f11 integer DEFAULT 0,
    od_r3_f12 integer DEFAULT 0,
    od_r3_f13 integer DEFAULT 0,
    od_r3_f14 integer DEFAULT 0,
    od_r3_f15 integer DEFAULT 0,
    od_r3_f16 integer DEFAULT 0,
    od_r3_f17 integer DEFAULT 0,
    od_r3_f18 integer DEFAULT 0,
    od_r4_f1 integer DEFAULT 0,
    od_r4_f2 integer DEFAULT 0,
    od_r4_f3 integer DEFAULT 0,
    od_r4_f4 integer DEFAULT 0,
    od_r4_f5 integer DEFAULT 0,
    od_r4_f6 integer DEFAULT 0,
    od_r4_f7 integer DEFAULT 0,
    od_r4_f8 integer DEFAULT 0,
    od_r4_f9 integer DEFAULT 0,
    od_r4_f10 integer DEFAULT 0,
    od_r4_f11 integer DEFAULT 0,
    od_r4_f12 integer DEFAULT 0,
    od_r4_f13 integer DEFAULT 0,
    od_r4_f14 integer DEFAULT 0,
    od_r4_f15 integer DEFAULT 0,
    od_r4_f16 integer DEFAULT 0,
    od_r4_f17 integer DEFAULT 0,
    od_r4_f18 integer DEFAULT 0,
    od_r5_f1 integer DEFAULT 0,
    od_r5_f2 integer DEFAULT 0,
    od_r5_f3 integer DEFAULT 0,
    od_r5_f4 integer DEFAULT 0,
    od_r5_f5 integer DEFAULT 0,
    od_r5_f6 integer DEFAULT 0,
    od_r5_f7 integer DEFAULT 0,
    od_r5_f8 integer DEFAULT 0,
    od_r5_f9 integer DEFAULT 0,
    od_r5_f10 integer DEFAULT 0,
    od_r5_f11 integer DEFAULT 0,
    od_r5_f12 integer DEFAULT 0,
    od_r5_f13 integer DEFAULT 0,
    od_r5_f14 integer DEFAULT 0,
    od_r5_f15 integer DEFAULT 0,
    od_r5_f16 integer DEFAULT 0,
    od_r5_f17 integer DEFAULT 0,
    od_r5_f18 integer DEFAULT 0,
    od_r6_f1 integer DEFAULT 0,
    od_r6_f2 integer DEFAULT 0,
    od_r6_f3 integer DEFAULT 0,
    od_r6_f4 integer DEFAULT 0,
    od_r6_f5 integer DEFAULT 0,
    od_r6_f6 integer DEFAULT 0,
    od_r6_f7 integer DEFAULT 0,
    od_r6_f8 integer DEFAULT 0,
    od_r6_f9 integer DEFAULT 0,
    od_r6_f10 integer DEFAULT 0,
    od_r6_f11 integer DEFAULT 0,
    od_r6_f12 integer DEFAULT 0,
    od_r6_f13 integer DEFAULT 0,
    od_r6_f14 integer DEFAULT 0,
    od_r6_f15 integer DEFAULT 0,
    od_r6_f16 integer DEFAULT 0,
    od_r6_f17 integer DEFAULT 0,
    od_r6_f18 integer DEFAULT 0,
    od_r7_f1 integer DEFAULT 0,
    od_r7_f2 integer DEFAULT 0,
    od_r7_f3 integer DEFAULT 0,
    od_r7_f4 integer DEFAULT 0,
    od_r7_f5 integer DEFAULT 0,
    od_r7_f6 integer DEFAULT 0,
    od_r7_f7 integer DEFAULT 0,
    od_r7_f8 integer DEFAULT 0,
    od_r7_f9 integer DEFAULT 0,
    od_r7_f10 integer DEFAULT 0,
    od_r7_f11 integer DEFAULT 0,
    od_r7_f12 integer DEFAULT 0,
    od_r7_f13 integer DEFAULT 0,
    od_r7_f14 integer DEFAULT 0,
    od_r7_f15 integer DEFAULT 0,
    od_r7_f16 integer DEFAULT 0,
    od_r7_f17 integer DEFAULT 0,
    od_r7_f18 integer DEFAULT 0,
    od_r8_f1 integer DEFAULT 0,
    od_r8_f2 integer DEFAULT 0,
    od_r8_f3 integer DEFAULT 0,
    od_r8_f4 integer DEFAULT 0,
    od_r8_f5 integer DEFAULT 0,
    od_r8_f6 integer DEFAULT 0,
    od_r8_f7 integer DEFAULT 0,
    od_r8_f8 integer DEFAULT 0,
    od_r8_f9 integer DEFAULT 0,
    od_r8_f10 integer DEFAULT 0,
    od_r8_f11 integer DEFAULT 0,
    od_r8_f12 integer DEFAULT 0,
    od_r8_f13 integer DEFAULT 0,
    od_r8_f14 integer DEFAULT 0,
    od_r8_f15 integer DEFAULT 0,
    od_r8_f16 integer DEFAULT 0,
    od_r8_f17 integer DEFAULT 0,
    od_r8_f18 integer DEFAULT 0,
    od_r9_f1 integer DEFAULT 0,
    od_r9_f2 integer DEFAULT 0,
    od_r9_f3 integer DEFAULT 0,
    od_r9_f4 integer DEFAULT 0,
    od_r9_f5 integer DEFAULT 0,
    od_r9_f6 integer DEFAULT 0,
    od_r9_f7 integer DEFAULT 0,
    od_r9_f8 integer DEFAULT 0,
    od_r9_f9 integer DEFAULT 0,
    od_r9_f10 integer DEFAULT 0,
    od_r9_f11 integer DEFAULT 0,
    od_r9_f12 integer DEFAULT 0,
    od_r9_f13 integer DEFAULT 0,
    od_r9_f14 integer DEFAULT 0,
    od_r9_f15 integer DEFAULT 0,
    od_r9_f16 integer DEFAULT 0,
    od_r9_f17 integer DEFAULT 0,
    od_r9_f18 integer DEFAULT 0,
    od_r10_f1 integer DEFAULT 0,
    od_r10_f2 integer DEFAULT 0,
    od_r10_f3 integer DEFAULT 0,
    od_r10_f4 integer DEFAULT 0,
    od_r10_f5 integer DEFAULT 0,
    od_r10_f6 integer DEFAULT 0,
    od_r10_f7 integer DEFAULT 0,
    od_r10_f8 integer DEFAULT 0,
    od_r10_f9 integer DEFAULT 0,
    od_r10_f10 integer DEFAULT 0,
    od_r10_f11 integer DEFAULT 0,
    od_r10_f12 integer DEFAULT 0,
    od_r10_f13 integer DEFAULT 0,
    od_r10_f14 integer DEFAULT 0,
    od_r10_f15 integer DEFAULT 0,
    od_r10_f16 integer DEFAULT 0,
    od_r10_f17 integer DEFAULT 0,
    od_r10_f18 integer DEFAULT 0,
    od_r11_f1 integer DEFAULT 0,
    od_r11_f2 integer DEFAULT 0,
    od_r11_f3 integer DEFAULT 0,
    od_r11_f4 integer DEFAULT 0,
    od_r11_f5 integer DEFAULT 0,
    od_r11_f6 integer DEFAULT 0,
    od_r11_f7 integer DEFAULT 0,
    od_r11_f8 integer DEFAULT 0,
    od_r11_f9 integer DEFAULT 0,
    od_r11_f10 integer DEFAULT 0,
    od_r11_f11 integer DEFAULT 0,
    od_r11_f12 integer DEFAULT 0,
    od_r11_f13 integer DEFAULT 0,
    od_r11_f14 integer DEFAULT 0,
    od_r11_f15 integer DEFAULT 0,
    od_r11_f16 integer DEFAULT 0,
    od_r11_f17 integer DEFAULT 0,
    od_r11_f18 integer DEFAULT 0,
    od_r12_f1 integer DEFAULT 0,
    od_r12_f2 integer DEFAULT 0,
    od_r12_f3 integer DEFAULT 0,
    od_r12_f4 integer DEFAULT 0,
    od_r12_f5 integer DEFAULT 0,
    od_r12_f6 integer DEFAULT 0,
    od_r12_f7 integer DEFAULT 0,
    od_r12_f8 integer DEFAULT 0,
    od_r12_f9 integer DEFAULT 0,
    od_r12_f10 integer DEFAULT 0,
    od_r12_f11 integer DEFAULT 0,
    od_r12_f12 integer DEFAULT 0,
    od_r12_f13 integer DEFAULT 0,
    od_r12_f14 integer DEFAULT 0,
    od_r12_f15 integer DEFAULT 0,
    od_r12_f16 integer DEFAULT 0,
    od_r12_f17 integer DEFAULT 0,
    od_r12_f18 integer DEFAULT 0,
    od_r13_f1 integer DEFAULT 0,
    od_r13_f2 integer DEFAULT 0,
    od_r13_f3 integer DEFAULT 0,
    od_r13_f4 integer DEFAULT 0,
    od_r13_f5 integer DEFAULT 0,
    od_r13_f6 integer DEFAULT 0,
    od_r13_f7 integer DEFAULT 0,
    od_r13_f8 integer DEFAULT 0,
    od_r13_f9 integer DEFAULT 0,
    od_r13_f10 integer DEFAULT 0,
    od_r13_f11 integer DEFAULT 0,
    od_r13_f12 integer DEFAULT 0,
    od_r13_f13 integer DEFAULT 0,
    od_r13_f14 integer DEFAULT 0,
    od_r13_f15 integer DEFAULT 0,
    od_r13_f16 integer DEFAULT 0,
    od_r13_f17 integer DEFAULT 0,
    od_r13_f18 integer DEFAULT 0,
    od_r14_f1 integer DEFAULT 0,
    od_r14_f2 integer DEFAULT 0,
    od_r14_f3 integer DEFAULT 0,
    od_r14_f4 integer DEFAULT 0,
    od_r14_f5 integer DEFAULT 0,
    od_r14_f6 integer DEFAULT 0,
    od_r14_f7 integer DEFAULT 0,
    od_r14_f8 integer DEFAULT 0,
    od_r14_f9 integer DEFAULT 0,
    od_r14_f10 integer DEFAULT 0,
    od_r14_f11 integer DEFAULT 0,
    od_r14_f12 integer DEFAULT 0,
    od_r14_f13 integer DEFAULT 0,
    od_r14_f14 integer DEFAULT 0,
    od_r14_f15 integer DEFAULT 0,
    od_r14_f16 integer DEFAULT 0,
    od_r14_f17 integer DEFAULT 0,
    od_r14_f18 integer DEFAULT 0,
    od_r15_f1 integer DEFAULT 0,
    od_r15_f2 integer DEFAULT 0,
    od_r15_f3 integer DEFAULT 0,
    od_r15_f4 integer DEFAULT 0,
    od_r15_f5 integer DEFAULT 0,
    od_r15_f6 integer DEFAULT 0,
    od_r15_f7 integer DEFAULT 0,
    od_r15_f8 integer DEFAULT 0,
    od_r15_f9 integer DEFAULT 0,
    od_r15_f10 integer DEFAULT 0,
    od_r15_f11 integer DEFAULT 0,
    od_r15_f12 integer DEFAULT 0,
    od_r15_f13 integer DEFAULT 0,
    od_r15_f14 integer DEFAULT 0,
    od_r15_f15 integer DEFAULT 0,
    od_r15_f16 integer DEFAULT 0,
    od_r15_f17 integer DEFAULT 0,
    od_r15_f18 integer DEFAULT 0,
    od_r16_f1 integer DEFAULT 0,
    od_r16_f2 integer DEFAULT 0,
    od_r16_f3 integer DEFAULT 0,
    od_r16_f4 integer DEFAULT 0,
    od_r16_f5 integer DEFAULT 0,
    od_r16_f6 integer DEFAULT 0,
    od_r16_f7 integer DEFAULT 0,
    od_r16_f8 integer DEFAULT 0,
    od_r16_f9 integer DEFAULT 0,
    od_r16_f10 integer DEFAULT 0,
    od_r16_f11 integer DEFAULT 0,
    od_r16_f12 integer DEFAULT 0,
    od_r16_f13 integer DEFAULT 0,
    od_r16_f14 integer DEFAULT 0,
    od_r16_f15 integer DEFAULT 0,
    od_r16_f16 integer DEFAULT 0,
    od_r16_f17 integer DEFAULT 0,
    od_r16_f18 integer DEFAULT 0,
    od_r17_f1 integer DEFAULT 0,
    od_r17_f2 integer DEFAULT 0,
    od_r17_f3 integer DEFAULT 0,
    od_r17_f4 integer DEFAULT 0,
    od_r17_f5 integer DEFAULT 0,
    od_r17_f6 integer DEFAULT 0,
    od_r17_f7 integer DEFAULT 0,
    od_r17_f8 integer DEFAULT 0,
    od_r17_f9 integer DEFAULT 0,
    od_r17_f10 integer DEFAULT 0,
    od_r17_f11 integer DEFAULT 0,
    od_r17_f12 integer DEFAULT 0,
    od_r17_f13 integer DEFAULT 0,
    od_r17_f14 integer DEFAULT 0,
    od_r17_f15 integer DEFAULT 0,
    od_r17_f16 integer DEFAULT 0,
    od_r17_f17 integer DEFAULT 0,
    od_r17_f18 integer DEFAULT 0,
    od_r18_f1 integer DEFAULT 0,
    od_r18_f2 integer DEFAULT 0,
    od_r18_f3 integer DEFAULT 0,
    od_r18_f4 integer DEFAULT 0,
    od_r18_f5 integer DEFAULT 0,
    od_r18_f6 integer DEFAULT 0,
    od_r18_f7 integer DEFAULT 0,
    od_r18_f8 integer DEFAULT 0,
    od_r18_f9 integer DEFAULT 0,
    od_r18_f10 integer DEFAULT 0,
    od_r18_f11 integer DEFAULT 0,
    od_r18_f12 integer DEFAULT 0,
    od_r18_f13 integer DEFAULT 0,
    od_r18_f14 integer DEFAULT 0,
    od_r18_f15 integer DEFAULT 0,
    od_r18_f16 integer DEFAULT 0,
    od_r18_f17 integer DEFAULT 0,
    od_r18_f18 integer DEFAULT 0,
    od_r19_f1 integer DEFAULT 0,
    od_r19_f2 integer DEFAULT 0,
    od_r19_f3 integer DEFAULT 0,
    od_r19_f4 integer DEFAULT 0,
    od_r19_f5 integer DEFAULT 0,
    od_r19_f6 integer DEFAULT 0,
    od_r19_f7 integer DEFAULT 0,
    od_r19_f8 integer DEFAULT 0,
    od_r19_f9 integer DEFAULT 0,
    od_r19_f10 integer DEFAULT 0,
    od_r19_f11 integer DEFAULT 0,
    od_r19_f12 integer DEFAULT 0,
    od_r19_f13 integer DEFAULT 0,
    od_r19_f14 integer DEFAULT 0,
    od_r19_f15 integer DEFAULT 0,
    od_r19_f16 integer DEFAULT 0,
    od_r19_f17 integer DEFAULT 0,
    od_r19_f18 integer DEFAULT 0,
    od_r20_f1 integer DEFAULT 0,
    od_r20_f2 integer DEFAULT 0,
    od_r20_f3 integer DEFAULT 0,
    od_r20_f4 integer DEFAULT 0,
    od_r20_f5 integer DEFAULT 0,
    od_r20_f6 integer DEFAULT 0,
    od_r20_f7 integer DEFAULT 0,
    od_r20_f8 integer DEFAULT 0,
    od_r20_f9 integer DEFAULT 0,
    od_r20_f10 integer DEFAULT 0,
    od_r20_f11 integer DEFAULT 0,
    od_r20_f12 integer DEFAULT 0,
    od_r20_f13 integer DEFAULT 0,
    od_r20_f14 integer DEFAULT 0,
    od_r20_f15 integer DEFAULT 0,
    od_r20_f16 integer DEFAULT 0,
    od_r20_f17 integer DEFAULT 0,
    od_r20_f18 integer DEFAULT 0,
    od_r21_f1 integer DEFAULT 0,
    od_r21_f2 integer DEFAULT 0,
    od_r21_f3 integer DEFAULT 0,
    od_r21_f4 integer DEFAULT 0,
    od_r21_f5 integer DEFAULT 0,
    od_r21_f6 integer DEFAULT 0,
    od_r21_f7 integer DEFAULT 0,
    od_r21_f8 integer DEFAULT 0,
    od_r21_f9 integer DEFAULT 0,
    od_r21_f10 integer DEFAULT 0,
    od_r21_f11 integer DEFAULT 0,
    od_r21_f12 integer DEFAULT 0,
    od_r21_f13 integer DEFAULT 0,
    od_r21_f14 integer DEFAULT 0,
    od_r21_f15 integer DEFAULT 0,
    od_r21_f16 integer DEFAULT 0,
    od_r21_f17 integer DEFAULT 0,
    od_r21_f18 integer DEFAULT 0,
    od_r22_f1 integer DEFAULT 0,
    od_r22_f2 integer DEFAULT 0,
    od_r22_f3 integer DEFAULT 0,
    od_r22_f4 integer DEFAULT 0,
    od_r22_f5 integer DEFAULT 0,
    od_r22_f6 integer DEFAULT 0,
    od_r22_f7 integer DEFAULT 0,
    od_r22_f8 integer DEFAULT 0,
    od_r22_f9 integer DEFAULT 0,
    od_r22_f10 integer DEFAULT 0,
    od_r22_f11 integer DEFAULT 0,
    od_r22_f12 integer DEFAULT 0,
    od_r22_f13 integer DEFAULT 0,
    od_r22_f14 integer DEFAULT 0,
    od_r22_f15 integer DEFAULT 0,
    od_r22_f16 integer DEFAULT 0,
    od_r22_f17 integer DEFAULT 0,
    od_r22_f18 integer DEFAULT 0,
    od_r23_f1 integer DEFAULT 0,
    od_r23_f2 integer DEFAULT 0,
    od_r23_f3 integer DEFAULT 0,
    od_r23_f4 integer DEFAULT 0,
    od_r23_f5 integer DEFAULT 0,
    od_r23_f6 integer DEFAULT 0,
    od_r23_f7 integer DEFAULT 0,
    od_r23_f8 integer DEFAULT 0,
    od_r23_f9 integer DEFAULT 0,
    od_r23_f10 integer DEFAULT 0,
    od_r23_f11 integer DEFAULT 0,
    od_r23_f12 integer DEFAULT 0,
    od_r23_f13 integer DEFAULT 0,
    od_r23_f14 integer DEFAULT 0,
    od_r23_f15 integer DEFAULT 0,
    od_r23_f16 integer DEFAULT 0,
    od_r23_f17 integer DEFAULT 0,
    od_r23_f18 integer DEFAULT 0,
    od_r24_f1 integer DEFAULT 0,
    od_r24_f2 integer DEFAULT 0,
    od_r24_f3 integer DEFAULT 0,
    od_r24_f4 integer DEFAULT 0,
    od_r24_f5 integer DEFAULT 0,
    od_r24_f6 integer DEFAULT 0,
    od_r24_f7 integer DEFAULT 0,
    od_r24_f8 integer DEFAULT 0,
    od_r24_f9 integer DEFAULT 0,
    od_r24_f10 integer DEFAULT 0,
    od_r24_f11 integer DEFAULT 0,
    od_r24_f12 integer DEFAULT 0,
    od_r24_f13 integer DEFAULT 0,
    od_r24_f14 integer DEFAULT 0,
    od_r24_f15 integer DEFAULT 0,
    od_r24_f16 integer DEFAULT 0,
    od_r24_f17 integer DEFAULT 0,
    od_r24_f18 integer DEFAULT 0,
    od_r25_f1 integer DEFAULT 0,
    od_r25_f2 integer DEFAULT 0,
    od_r25_f3 integer DEFAULT 0,
    od_r25_f4 integer DEFAULT 0,
    od_r25_f5 integer DEFAULT 0,
    od_r25_f6 integer DEFAULT 0,
    od_r25_f7 integer DEFAULT 0,
    od_r25_f8 integer DEFAULT 0,
    od_r25_f9 integer DEFAULT 0,
    od_r25_f10 integer DEFAULT 0,
    od_r25_f11 integer DEFAULT 0,
    od_r25_f12 integer DEFAULT 0,
    od_r25_f13 integer DEFAULT 0,
    od_r25_f14 integer DEFAULT 0,
    od_r25_f15 integer DEFAULT 0,
    od_r25_f16 integer DEFAULT 0,
    od_r25_f17 integer DEFAULT 0,
    od_r25_f18 integer DEFAULT 0,
    od_r26_f1 integer DEFAULT 0,
    od_r26_f2 integer DEFAULT 0,
    od_r26_f3 integer DEFAULT 0,
    od_r26_f4 integer DEFAULT 0,
    od_r26_f5 integer DEFAULT 0,
    od_r26_f6 integer DEFAULT 0,
    od_r26_f7 integer DEFAULT 0,
    od_r26_f8 integer DEFAULT 0,
    od_r26_f9 integer DEFAULT 0,
    od_r26_f10 integer DEFAULT 0,
    od_r26_f11 integer DEFAULT 0,
    od_r26_f12 integer DEFAULT 0,
    od_r26_f13 integer DEFAULT 0,
    od_r26_f14 integer DEFAULT 0,
    od_r26_f15 integer DEFAULT 0,
    od_r26_f16 integer DEFAULT 0,
    od_r26_f17 integer DEFAULT 0,
    od_r26_f18 integer DEFAULT 0,
    ttod_r1_f1 integer DEFAULT 0,
    ttod_r1_f2 integer DEFAULT 0,
    ttod_r1_f3 integer DEFAULT 0,
    ttod_r1_f4 integer DEFAULT 0,
    ttod_r1_f5 integer DEFAULT 0,
    ttod_r1_f6 integer DEFAULT 0,
    ttod_r2_f1 integer DEFAULT 0,
    ttod_r2_f2 integer DEFAULT 0,
    ttod_r2_f3 integer DEFAULT 0,
    ttod_r2_f4 integer DEFAULT 0,
    ttod_r2_f5 integer DEFAULT 0,
    ttod_r2_f6 integer DEFAULT 0,
    ttod_r3_f1 integer DEFAULT 0,
    ttod_r3_f2 integer DEFAULT 0,
    ttod_r3_f3 integer DEFAULT 0,
    ttod_r3_f4 integer DEFAULT 0,
    ttod_r3_f5 integer DEFAULT 0,
    ttod_r3_f6 integer DEFAULT 0,
    ttod_r4_f1 integer DEFAULT 0,
    ttod_r4_f2 integer DEFAULT 0,
    ttod_r4_f3 integer DEFAULT 0,
    ttod_r4_f4 integer DEFAULT 0,
    ttod_r4_f5 integer DEFAULT 0,
    ttod_r4_f6 integer DEFAULT 0,
    ttod_r5_f1 integer DEFAULT 0,
    ttod_r5_f2 integer DEFAULT 0,
    ttod_r5_f3 integer DEFAULT 0,
    ttod_r5_f4 integer DEFAULT 0,
    ttod_r5_f5 integer DEFAULT 0,
    ttod_r5_f6 integer DEFAULT 0,
    ttod_r6_f1 integer DEFAULT 0,
    ttod_r6_f2 integer DEFAULT 0,
    ttod_r6_f3 integer DEFAULT 0,
    ttod_r6_f4 integer DEFAULT 0,
    ttod_r6_f5 integer DEFAULT 0,
    ttod_r6_f6 integer DEFAULT 0,
    ttod_r7_f1 integer DEFAULT 0,
    ttod_r7_f2 integer DEFAULT 0,
    ttod_r7_f3 integer DEFAULT 0,
    ttod_r7_f4 integer DEFAULT 0,
    ttod_r7_f5 integer DEFAULT 0,
    ttod_r7_f6 integer DEFAULT 0,
    ttod_r8_f1 integer DEFAULT 0,
    ttod_r8_f2 integer DEFAULT 0,
    ttod_r8_f3 integer DEFAULT 0,
    ttod_r8_f4 integer DEFAULT 0,
    ttod_r8_f5 integer DEFAULT 0,
    ttod_r8_f6 integer DEFAULT 0,
    ttod_r9_f1 integer DEFAULT 0,
    ttod_r9_f2 integer DEFAULT 0,
    ttod_r9_f3 integer DEFAULT 0,
    ttod_r9_f4 integer DEFAULT 0,
    ttod_r9_f5 integer DEFAULT 0,
    ttod_r9_f6 integer DEFAULT 0,
    ttod_r10_f1 integer DEFAULT 0,
    ttod_r10_f2 integer DEFAULT 0,
    ttod_r10_f3 integer DEFAULT 0,
    ttod_r10_f4 integer DEFAULT 0,
    ttod_r10_f5 integer DEFAULT 0,
    ttod_r10_f6 integer DEFAULT 0,
    mv_vacc_planned integer DEFAULT 0,
    mv_vacc_held integer DEFAULT 0,
    od_r1_f20 integer DEFAULT 0,
    od_r2_f20 integer DEFAULT 0,
    od_r3_f20 integer DEFAULT 0,
    od_r4_f20 integer DEFAULT 0,
    od_r5_f20 integer DEFAULT 0,
    od_r6_f20 integer DEFAULT 0,
    od_r7_f20 integer DEFAULT 0,
    od_r8_f20 integer DEFAULT 0,
    od_r9_f20 integer DEFAULT 0,
    od_r10_f20 integer DEFAULT 0,
    od_r11_f20 integer DEFAULT 0,
    od_r12_f20 integer DEFAULT 0,
    od_r13_f20 integer DEFAULT 0,
    od_r14_f20 integer DEFAULT 0,
    od_r15_f20 integer DEFAULT 0,
    od_r16_f20 integer DEFAULT 0,
    od_r17_f20 integer DEFAULT 0,
    od_r18_f20 integer DEFAULT 0,
    od_r19_f20 integer DEFAULT 0,
    od_r20_f20 integer DEFAULT 0,
    od_r21_f20 integer DEFAULT 0,
    od_r22_f20 integer DEFAULT 0,
    od_r23_f20 integer DEFAULT 0,
    od_r24_f20 integer DEFAULT 0,
    od_r25_f20 integer DEFAULT 0,
    od_r26_f20 integer DEFAULT 0,
    od_r1_f21 integer DEFAULT 0,
    od_r2_f21 integer DEFAULT 0,
    od_r3_f21 integer DEFAULT 0,
    od_r4_f21 integer DEFAULT 0,
    od_r5_f21 integer DEFAULT 0,
    od_r6_f21 integer DEFAULT 0,
    od_r7_f21 integer DEFAULT 0,
    od_r8_f21 integer DEFAULT 0,
    od_r9_f21 integer DEFAULT 0,
    od_r10_f21 integer DEFAULT 0,
    od_r11_f21 integer DEFAULT 0,
    od_r12_f21 integer DEFAULT 0,
    od_r13_f21 integer DEFAULT 0,
    od_r14_f21 integer DEFAULT 0,
    od_r15_f21 integer DEFAULT 0,
    od_r16_f21 integer DEFAULT 0,
    od_r17_f21 integer DEFAULT 0,
    od_r18_f21 integer DEFAULT 0,
    od_r19_f21 integer DEFAULT 0,
    od_r20_f21 integer DEFAULT 0,
    od_r21_f21 integer DEFAULT 0,
    od_r22_f21 integer DEFAULT 0,
    od_r23_f21 integer DEFAULT 0,
    od_r24_f21 integer DEFAULT 0,
    od_r25_f21 integer DEFAULT 0,
    od_r26_f21 integer DEFAULT 0,
    od_r1_f19 integer DEFAULT 0,
    od_r2_f19 integer DEFAULT 0,
    od_r3_f19 integer DEFAULT 0,
    od_r4_f19 integer DEFAULT 0,
    od_r5_f19 integer DEFAULT 0,
    od_r6_f19 integer DEFAULT 0,
    od_r7_f19 integer DEFAULT 0,
    od_r8_f19 integer DEFAULT 0,
    od_r9_f19 integer DEFAULT 0,
    od_r10_f19 integer DEFAULT 0,
    od_r11_f19 integer DEFAULT 0,
    od_r12_f19 integer DEFAULT 0,
    od_r13_f19 integer DEFAULT 0,
    od_r14_f19 integer DEFAULT 0,
    od_r15_f19 integer DEFAULT 0,
    od_r16_f19 integer DEFAULT 0,
    od_r17_f19 integer DEFAULT 0,
    od_r18_f19 integer DEFAULT 0,
    od_r19_f19 integer DEFAULT 0,
    od_r20_f19 integer DEFAULT 0,
    od_r21_f19 integer DEFAULT 0,
    od_r22_f19 integer DEFAULT 0,
    od_r23_f19 integer DEFAULT 0,
    od_r24_f19 integer DEFAULT 0,
    od_r25_f19 integer DEFAULT 0,
    od_r26_f19 integer DEFAULT 0
);


ALTER TABLE public.fac_mvrf_od_db OWNER TO postgres;

--
-- Name: facilities_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE facilities_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.facilities_id_seq OWNER TO postgres;

--
-- Name: facilities; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE facilities (
    facid character varying NOT NULL,
    facode character varying(15),
    fac_name character varying(100),
    tcode character varying(6),
    incharge character varying(150),
    designation character varying(50),
    uncode character varying(10),
    distcode character varying(3),
    procode character varying(2),
    areatype character varying(15),
    fatype character varying(15),
    addedby integer DEFAULT 0,
    addeddate character varying,
    updateddate character varying,
    batch_status character varying(2) DEFAULT 0,
    catchment_area_pop character varying(50) DEFAULT 0,
    status character varying(1),
    func_status character varying(1),
    rep_status character varying(1),
    fac_class character varying(10),
    senctioned character varying,
    med1 character varying,
    med2 character varying,
    med3 character varying,
    med4 character varying,
    med5 character varying,
    med6 character varying,
    med7 character varying,
    med8 character varying,
    med9 character varying,
    med10 character varying,
    med11 character varying,
    med12 character varying,
    med13 character varying,
    med14 character varying,
    med15 character varying,
    med16 character varying,
    med17 character varying,
    med18 character varying,
    med19 character varying,
    med20 character varying,
    med21 character varying,
    med22 character varying,
    med23 character varying,
    med24 character varying,
    med25 character varying,
    med26 character varying,
    med27 character varying,
    med28 character varying,
    med29 character varying,
    med30 character varying,
    med31 character varying,
    is_vacc_fac character varying(1),
    is_ds_fac character varying(1),
    update_status character varying(2),
    sync_status character varying(2),
    hf_type character varying(2),
    hf_manage character varying(2),
    hf_time character varying(2),
    hf_status character varying(2),
    id integer DEFAULT nextval('facilities_id_seq'::regclass) NOT NULL,
    epi_center_address text,
    fac_address text
);


ALTER TABLE public.facilities OWNER TO postgres;

--
-- Name: COLUMN facilities.is_vacc_fac; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN facilities.is_vacc_fac IS 'It indicates if it is a vaccination facility';


--
-- Name: COLUMN facilities.is_ds_fac; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN facilities.is_ds_fac IS 'It indicates if it is a disease surveillance facility';


--
-- Name: facilities_population_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE facilities_population_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.facilities_population_id_seq OWNER TO postgres;

--
-- Name: facilities_population; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE facilities_population (
    id integer DEFAULT nextval('facilities_population_id_seq'::regclass) NOT NULL,
    facode character varying(6),
    year character varying(4),
    population integer,
    created_date date,
    update_date date,
    update_by text,
    distcode character varying(3),
    tcode character varying(6),
    uncode character varying(9)
);


ALTER TABLE public.facilities_population OWNER TO postgres;

--
-- Name: facilities_status; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE facilities_status (
    id character varying(20) NOT NULL,
    facode character varying(6),
    status character varying(2),
    m_y_from character varying(7) DEFAULT NULL::character varying,
    m_y_to character varying(7),
    w_y_from character varying(7) DEFAULT NULL::character varying,
    w_y_to character varying(7),
    added_by integer,
    added_date character varying(10),
    updated_date character varying(10),
    reason_vacc text,
    reason_ds text
);


ALTER TABLE public.facilities_status OWNER TO postgres;

--
-- Name: facilities_status_backup; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE facilities_status_backup (
    id character varying NOT NULL,
    facode character varying(6),
    status character varying(2),
    m_y_from character varying(7) DEFAULT NULL::character varying,
    m_y_to character varying(7),
    w_y_from character varying(7) DEFAULT NULL::character varying,
    w_y_to character varying(7),
    added_by integer,
    added_date character varying(10),
    updated_date character varying(10)
);


ALTER TABLE public.facilities_status_backup OWNER TO postgres;

--
-- Name: facilities_status_reason_vacc_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE facilities_status_reason_vacc_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.facilities_status_reason_vacc_seq OWNER TO postgres;

--
-- Name: facilities_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE facilities_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1
    CYCLE;


ALTER TABLE public.facilities_types_id_seq OWNER TO postgres;

--
-- Name: facilities_types; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE facilities_types (
    id integer DEFAULT nextval('facilities_types_id_seq'::regclass) NOT NULL,
    fatype text,
    fatype_name text,
    facat text,
    facat_name text,
    display_order integer
);


ALTER TABLE public.facilities_types OWNER TO postgres;

--
-- Name: feedback_db_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE feedback_db_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.feedback_db_seq OWNER TO postgres;

--
-- Name: feedback_db; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE feedback_db (
    recid integer DEFAULT nextval('feedback_db_seq'::regclass) NOT NULL,
    have_any_difficulty character varying(3),
    use_any_report character varying(3),
    comments text,
    submitted_date date NOT NULL
);


ALTER TABLE public.feedback_db OWNER TO postgres;

--
-- Name: filter_series_names; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE filter_series_names (
    pk_id integer NOT NULL,
    filter_detail_id integer NOT NULL,
    series_name character varying(20) NOT NULL,
    "order" integer,
    extra_value_divider double precision,
    sub_indicator_id integer
);


ALTER TABLE public.filter_series_names OWNER TO postgres;

--
-- Name: filter_series_names_filter_detail_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE filter_series_names_filter_detail_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.filter_series_names_filter_detail_id_seq OWNER TO postgres;

--
-- Name: filter_series_names_filter_detail_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE filter_series_names_filter_detail_id_seq OWNED BY filter_series_names.filter_detail_id;


--
-- Name: filter_series_names_order_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE filter_series_names_order_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.filter_series_names_order_seq OWNER TO postgres;

--
-- Name: filter_series_names_order_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE filter_series_names_order_seq OWNED BY filter_series_names."order";


--
-- Name: flcf_vacc_mr_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE flcf_vacc_mr_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999999
    CACHE 1;


ALTER TABLE public.flcf_vacc_mr_id_seq OWNER TO postgres;

--
-- Name: flcf_vacc_mr; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE flcf_vacc_mr (
    id integer DEFAULT nextval('flcf_vacc_mr_id_seq'::regclass) NOT NULL,
    procode character varying(1) DEFAULT 3 NOT NULL,
    distcode character varying(3) NOT NULL,
    facode character varying(6),
    tcode character varying(8) NOT NULL,
    fmonth character varying(8) NOT NULL,
    tc_male integer DEFAULT 0,
    tc_female integer DEFAULT 0,
    pw_monthly_target integer DEFAULT 0,
    tot_lhw_attached integer DEFAULT 0,
    tot_lhw_involved_vacc integer DEFAULT 0,
    tot_fixed_centers integer DEFAULT 0,
    functioning_centers integer DEFAULT 0,
    or_vacc_planned integer DEFAULT 0,
    or_vacc_held integer DEFAULT 0,
    hh_vacc_planned integer DEFAULT 0,
    hh_vacc_held integer DEFAULT 0,
    cri_r1_f1 integer DEFAULT 0,
    cri_r1_f2 integer DEFAULT 0,
    cri_r1_f3 integer DEFAULT 0 NOT NULL,
    cri_r1_f4 integer DEFAULT 0 NOT NULL,
    cri_r1_f5 integer DEFAULT 0 NOT NULL,
    cri_r1_f6 integer DEFAULT 0 NOT NULL,
    cri_r1_f7 integer DEFAULT 0,
    cri_r1_f8 integer DEFAULT 0,
    cri_r1_f9 integer DEFAULT 0,
    cri_r1_f10 integer DEFAULT 0,
    cri_r1_f11 integer DEFAULT 0 NOT NULL,
    cri_r1_f12 integer DEFAULT 0 NOT NULL,
    cri_r1_f13 integer DEFAULT 0,
    cri_r1_f14 integer DEFAULT 0,
    cri_r2_f1 integer DEFAULT 0,
    cri_r2_f2 integer DEFAULT 0 NOT NULL,
    cri_r2_f3 integer DEFAULT 0 NOT NULL,
    cri_r2_f4 integer DEFAULT 0 NOT NULL,
    cri_r2_f5 integer DEFAULT 0 NOT NULL,
    cri_r2_f6 integer DEFAULT 0 NOT NULL,
    cri_r2_f7 integer DEFAULT 0,
    cri_r2_f8 integer DEFAULT 0,
    cri_r2_f9 integer DEFAULT 0,
    cri_r2_f10 integer DEFAULT 0,
    cri_r2_f11 integer DEFAULT 0 NOT NULL,
    cri_r2_f12 integer DEFAULT 0 NOT NULL,
    cri_r2_f13 integer DEFAULT 0,
    cri_r2_f14 integer DEFAULT 0,
    cri_r3_f1 integer DEFAULT 0,
    cri_r3_f2 integer DEFAULT 0,
    cri_r3_f3 integer DEFAULT 0 NOT NULL,
    cri_r3_f4 integer DEFAULT 0 NOT NULL,
    cri_r3_f5 integer DEFAULT 0 NOT NULL,
    cri_r3_f6 integer DEFAULT 0 NOT NULL,
    cri_r3_f7 integer DEFAULT 0,
    cri_r3_f8 integer DEFAULT 0,
    cri_r3_f9 integer DEFAULT 0,
    cri_r3_f10 integer DEFAULT 0,
    cri_r3_f11 integer DEFAULT 0 NOT NULL,
    cri_r3_f12 integer DEFAULT 0 NOT NULL,
    cri_r3_f13 integer DEFAULT 0,
    cri_r3_f14 integer DEFAULT 0,
    cri_r4_f1 integer DEFAULT 0,
    cri_r4_f2 integer DEFAULT 0,
    cri_r4_f3 integer DEFAULT 0,
    cri_r4_f4 integer DEFAULT 0,
    cri_r4_f5 integer DEFAULT 0,
    cri_r4_f6 integer DEFAULT 0,
    cri_r4_f7 integer DEFAULT 0,
    cri_r4_f8 integer DEFAULT 0,
    cri_r4_f9 integer DEFAULT 0,
    cri_r4_f10 integer DEFAULT 0,
    cri_r4_f11 integer DEFAULT 0,
    cri_r4_f12 integer DEFAULT 0,
    cri_r4_f13 integer DEFAULT 0,
    cri_r4_f14 integer DEFAULT 0,
    cri_r5_f1 integer DEFAULT 0,
    cri_r5_f2 integer DEFAULT 0,
    cri_r5_f3 integer DEFAULT 0,
    cri_r5_f4 integer DEFAULT 0,
    cri_r5_f5 integer DEFAULT 0,
    cri_r5_f6 integer DEFAULT 0,
    cri_r5_f7 integer DEFAULT 0,
    cri_r5_f8 integer DEFAULT 0,
    cri_r5_f9 integer DEFAULT 0,
    cri_r5_f10 integer DEFAULT 0,
    cri_r5_f11 integer DEFAULT 0,
    cri_r5_f12 integer DEFAULT 0,
    cri_r5_f13 integer DEFAULT 0,
    cri_r5_f14 integer DEFAULT 0,
    cri_r6_f1 integer DEFAULT 0,
    cri_r6_f2 integer DEFAULT 0,
    cri_r6_f3 integer DEFAULT 0,
    cri_r6_f4 integer DEFAULT 0,
    cri_r6_f5 integer DEFAULT 0,
    cri_r6_f6 integer DEFAULT 0,
    cri_r6_f7 integer DEFAULT 0,
    cri_r6_f8 integer DEFAULT 0,
    cri_r6_f9 integer DEFAULT 0,
    cri_r6_f10 integer DEFAULT 0,
    cri_r6_f11 integer DEFAULT 0,
    cri_r6_f12 integer DEFAULT 0,
    cri_r6_f13 integer DEFAULT 0,
    cri_r6_f14 integer DEFAULT 0,
    cri_r7_f1 integer DEFAULT 0,
    cri_r7_f2 integer DEFAULT 0,
    cri_r7_f3 integer DEFAULT 0,
    cri_r7_f4 integer DEFAULT 0,
    cri_r7_f5 integer DEFAULT 0,
    cri_r7_f6 integer DEFAULT 0,
    cri_r7_f7 integer DEFAULT 0,
    cri_r7_f8 integer DEFAULT 0,
    cri_r7_f9 integer DEFAULT 0,
    cri_r7_f10 integer DEFAULT 0,
    cri_r7_f11 integer DEFAULT 0,
    cri_r7_f12 integer DEFAULT 0,
    cri_r7_f13 integer DEFAULT 0,
    cri_r7_f14 integer DEFAULT 0,
    cri_r8_f1 integer DEFAULT 0,
    cri_r8_f2 integer DEFAULT 0,
    cri_r8_f3 integer DEFAULT 0,
    cri_r8_f4 integer DEFAULT 0,
    cri_r8_f5 integer DEFAULT 0,
    cri_r8_f6 integer DEFAULT 0,
    cri_r8_f7 integer DEFAULT 0,
    cri_r8_f8 integer DEFAULT 0,
    cri_r8_f9 integer DEFAULT 0,
    cri_r8_f10 integer DEFAULT 0,
    cri_r8_f11 integer DEFAULT 0,
    cri_r8_f12 integer DEFAULT 0,
    cri_r8_f13 integer DEFAULT 0,
    cri_r8_f14 integer DEFAULT 0,
    cri_r9_f1 integer DEFAULT 0,
    cri_r9_f2 integer DEFAULT 0,
    cri_r9_f3 integer DEFAULT 0,
    cri_r9_f4 integer DEFAULT 0,
    cri_r9_f5 integer DEFAULT 0,
    cri_r9_f6 integer DEFAULT 0,
    cri_r9_f7 integer DEFAULT 0,
    cri_r9_f8 integer DEFAULT 0,
    cri_r9_f9 integer DEFAULT 0,
    cri_r9_f10 integer DEFAULT 0,
    cri_r9_f11 integer DEFAULT 0,
    cri_r9_f12 integer DEFAULT 0,
    cri_r9_f13 integer DEFAULT 0,
    cri_r9_f14 integer DEFAULT 0,
    cri_r10_f1 integer DEFAULT 0,
    cri_r10_f2 integer DEFAULT 0,
    cri_r10_f3 integer DEFAULT 0,
    cri_r10_f4 integer DEFAULT 0,
    cri_r10_f5 integer DEFAULT 0 NOT NULL,
    cri_r10_f6 integer DEFAULT 0 NOT NULL,
    cri_r10_f7 integer DEFAULT 0,
    cri_r10_f8 integer DEFAULT 0,
    cri_r10_f9 integer DEFAULT 0,
    cri_r10_f10 integer DEFAULT 0,
    cri_r10_f11 integer DEFAULT 0,
    cri_r10_f12 integer DEFAULT 0,
    cri_r10_f13 integer DEFAULT 0,
    cri_r10_f14 integer DEFAULT 0,
    cri_r11_f1 integer DEFAULT 0,
    cri_r11_f2 integer DEFAULT 0,
    cri_r11_f3 integer DEFAULT 0,
    cri_r11_f4 integer DEFAULT 0,
    cri_r11_f5 integer DEFAULT 0 NOT NULL,
    cri_r11_f6 integer DEFAULT 0 NOT NULL,
    cri_r11_f7 integer DEFAULT 0,
    cri_r11_f8 integer DEFAULT 0,
    cri_r11_f9 integer DEFAULT 0,
    cri_r11_f10 integer DEFAULT 0,
    cri_r11_f11 integer DEFAULT 0,
    cri_r11_f12 integer DEFAULT 0,
    cri_r11_f13 integer DEFAULT 0,
    cri_r11_f14 integer DEFAULT 0,
    cri_r12_f1 integer DEFAULT 0,
    cri_r12_f2 integer DEFAULT 0,
    cri_r12_f3 integer DEFAULT 0,
    cri_r12_f4 integer DEFAULT 0,
    cri_r12_f5 integer DEFAULT 0 NOT NULL,
    cri_r12_f6 integer DEFAULT 0 NOT NULL,
    cri_r12_f7 integer DEFAULT 0,
    cri_r12_f8 integer DEFAULT 0,
    cri_r12_f9 integer DEFAULT 0,
    cri_r12_f10 integer DEFAULT 0,
    cri_r12_f11 integer DEFAULT 0,
    cri_r12_f12 integer DEFAULT 0,
    cri_r12_f13 integer DEFAULT 0,
    cri_r12_f14 integer DEFAULT 0,
    cri_r13_f1 integer DEFAULT 0,
    cri_r13_f2 integer DEFAULT 0,
    cri_r13_f3 integer DEFAULT 0,
    cri_r13_f4 integer DEFAULT 0,
    cri_r13_f5 integer DEFAULT 0,
    cri_r13_f6 integer DEFAULT 0,
    cri_r13_f7 integer DEFAULT 0,
    cri_r13_f8 integer DEFAULT 0,
    cri_r13_f9 integer DEFAULT 0,
    cri_r13_f10 integer DEFAULT 0,
    cri_r13_f11 integer DEFAULT 0,
    cri_r13_f12 integer DEFAULT 0,
    cri_r13_f13 integer DEFAULT 0,
    cri_r13_f14 integer DEFAULT 0,
    cri_r14_f1 integer DEFAULT 0,
    cri_r14_f2 integer DEFAULT 0,
    cri_r14_f3 integer DEFAULT 0,
    cri_r14_f4 integer DEFAULT 0,
    cri_r14_f5 integer DEFAULT 0,
    cri_r14_f6 integer DEFAULT 0,
    cri_r14_f7 integer DEFAULT 0,
    cri_r14_f8 integer DEFAULT 0,
    cri_r14_f9 integer DEFAULT 0,
    cri_r14_f10 integer DEFAULT 0,
    cri_r14_f11 integer DEFAULT 0,
    cri_r14_f12 integer DEFAULT 0,
    cri_r14_f13 integer DEFAULT 0,
    cri_r14_f14 integer DEFAULT 0,
    cri_r15_f1 integer DEFAULT 0 NOT NULL,
    cri_r15_f2 integer DEFAULT 0 NOT NULL,
    cri_r15_f3 integer DEFAULT 0,
    cri_r15_f4 integer DEFAULT 0,
    cri_r15_f5 integer DEFAULT 0,
    cri_r15_f6 integer DEFAULT 0,
    cri_r15_f7 integer DEFAULT 0,
    cri_r15_f8 integer DEFAULT 0,
    cri_r15_f9 integer DEFAULT 0 NOT NULL,
    cri_r15_f10 integer DEFAULT 0 NOT NULL,
    cri_r15_f11 integer DEFAULT 0,
    cri_r15_f12 integer DEFAULT 0,
    cri_r15_f13 integer DEFAULT 0,
    cri_r15_f14 integer DEFAULT 0,
    ttri_r1_f1 integer DEFAULT 0,
    ttri_r1_f2 integer DEFAULT 0,
    ttri_r1_f3 integer DEFAULT 0,
    ttri_r1_f4 integer DEFAULT 0,
    ttri_r1_f5 integer DEFAULT 0,
    ttri_r1_f6 integer DEFAULT 0,
    ttri_r2_f1 integer DEFAULT 0,
    ttri_r2_f2 integer DEFAULT 0,
    ttri_r2_f3 integer DEFAULT 0,
    ttri_r2_f4 integer DEFAULT 0,
    ttri_r2_f5 integer DEFAULT 0,
    ttri_r2_f6 integer DEFAULT 0,
    ttri_r3_f1 integer DEFAULT 0,
    ttri_r3_f2 integer DEFAULT 0,
    ttri_r3_f3 integer DEFAULT 0,
    ttri_r3_f4 integer DEFAULT 0,
    ttri_r3_f5 integer DEFAULT 0,
    ttri_r3_f6 integer DEFAULT 0,
    ttri_r4_f1 integer DEFAULT 0,
    ttri_r4_f2 integer DEFAULT 0,
    ttri_r4_f3 integer DEFAULT 0,
    ttri_r4_f4 integer DEFAULT 0,
    ttri_r4_f5 integer DEFAULT 0,
    ttri_r4_f6 integer DEFAULT 0,
    ttri_r5_f1 integer DEFAULT 0,
    ttri_r5_f2 integer DEFAULT 0,
    ttri_r5_f3 integer DEFAULT 0,
    ttri_r5_f4 integer DEFAULT 0,
    ttri_r5_f5 integer DEFAULT 0,
    ttri_r5_f6 integer DEFAULT 0,
    submitted_date date,
    vacc_name text,
    lhsname character varying(40),
    incharge_name text,
    uncode character varying(9) NOT NULL,
    cri_r16_f1 integer DEFAULT 0,
    cri_r16_f2 integer DEFAULT 0,
    cri_r16_f3 integer,
    cri_r16_f4 integer,
    cri_r16_f5 integer,
    cri_r16_f6 integer,
    cri_r16_f7 integer,
    cri_r16_f8 integer,
    cri_r16_f9 integer,
    cri_r16_f10 integer,
    cri_r16_f11 integer,
    cri_r16_f12 integer,
    cri_r16_f13 integer,
    cri_r16_f14 integer,
    cri_r17_f1 integer DEFAULT 0,
    cri_r17_f2 integer DEFAULT 0,
    cri_r17_f3 integer,
    cri_r17_f4 integer,
    cri_r17_f5 integer,
    cri_r17_f6 integer,
    cri_r17_f7 integer,
    cri_r17_f8 integer,
    cri_r17_f9 integer,
    cri_r17_f10 integer,
    cri_r17_f11 integer,
    cri_r17_f12 integer,
    cri_r17_f13 integer,
    cri_r17_f14 integer,
    cri_r18_f3 integer,
    cri_r18_f4 integer,
    cri_r18_f5 integer,
    cri_r18_f6 integer,
    cri_r18_f7 integer,
    cri_r18_f8 integer,
    cri_r18_f9 integer,
    cri_r18_f10 integer,
    cri_r18_f11 integer,
    cri_r18_f12 integer,
    cri_r18_f13 integer,
    cri_r18_f14 integer,
    cri_r18_f1 integer,
    cri_r18_f2 integer,
    ttri_r6_f1 integer,
    ttri_r6_f2 integer,
    ttri_r6_f3 integer,
    ttri_r6_f4 integer,
    ttri_r6_f5 integer,
    ttri_r6_f6 integer,
    techniciancode character varying(9),
    reporting integer,
    fixed_vacc_planned integer DEFAULT 0,
    fixed_vacc_held integer DEFAULT 0,
    reporting_centers character varying(30)
);


ALTER TABLE public.flcf_vacc_mr OWNER TO postgres;

--
-- Name: flcf_vacc_mr_old; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE flcf_vacc_mr_old (
    id integer DEFAULT nextval('flcf_vacc_mr_id_seq'::regclass) NOT NULL,
    procode character varying(1) DEFAULT '3'::character varying NOT NULL,
    distcode character varying(3) NOT NULL,
    facode character varying(6) NOT NULL,
    tcode character varying(8) NOT NULL,
    fmonth character varying(8) NOT NULL,
    tc_male integer DEFAULT 0,
    tc_female integer DEFAULT 0,
    pw_monthly_target integer DEFAULT 0,
    tot_lhw_attached integer DEFAULT 0,
    tot_lhw_involved_vacc integer DEFAULT 0,
    tot_fixed_centers integer DEFAULT 0,
    functioning_centers integer DEFAULT 0,
    or_vacc_planned integer DEFAULT 0,
    or_vacc_held integer DEFAULT 0,
    hh_vacc_planned integer DEFAULT 0,
    hh_vacc_held integer DEFAULT 0,
    cri_r1_f1 integer DEFAULT 0,
    cri_r1_f2 integer DEFAULT 0,
    cri_r1_f7 integer DEFAULT 0,
    cri_r1_f8 integer DEFAULT 0,
    cri_r1_f9 integer DEFAULT 0,
    cri_r1_f10 integer DEFAULT 0,
    cri_r1_f13 integer DEFAULT 0,
    cri_r1_f14 integer DEFAULT 0,
    cri_r2_f1 integer DEFAULT 0,
    cri_r2_f2 integer DEFAULT 0,
    cri_r2_f7 integer DEFAULT 0,
    cri_r2_f8 integer DEFAULT 0,
    cri_r2_f9 integer DEFAULT 0,
    cri_r2_f10 integer DEFAULT 0,
    cri_r2_f13 integer DEFAULT 0,
    cri_r2_f14 integer DEFAULT 0,
    cri_r3_f1 integer DEFAULT 0,
    cri_r3_f2 integer DEFAULT 0,
    cri_r3_f7 integer DEFAULT 0,
    cri_r3_f8 integer DEFAULT 0,
    cri_r3_f9 integer DEFAULT 0,
    cri_r3_f10 integer DEFAULT 0,
    cri_r3_f13 integer DEFAULT 0,
    cri_r3_f14 integer DEFAULT 0,
    cri_r4_f1 integer DEFAULT 0,
    cri_r4_f2 integer DEFAULT 0,
    cri_r4_f3 integer DEFAULT 0,
    cri_r4_f4 integer DEFAULT 0,
    cri_r4_f5 integer DEFAULT 0,
    cri_r4_f6 integer DEFAULT 0,
    cri_r4_f7 integer DEFAULT 0,
    cri_r4_f8 integer DEFAULT 0,
    cri_r4_f9 integer DEFAULT 0,
    cri_r4_f10 integer DEFAULT 0,
    cri_r4_f11 integer DEFAULT 0,
    cri_r4_f12 integer DEFAULT 0,
    cri_r4_f13 integer DEFAULT 0,
    cri_r4_f14 integer DEFAULT 0,
    cri_r5_f1 integer DEFAULT 0,
    cri_r5_f2 integer DEFAULT 0,
    cri_r5_f3 integer DEFAULT 0,
    cri_r5_f4 integer DEFAULT 0,
    cri_r5_f5 integer DEFAULT 0,
    cri_r5_f6 integer DEFAULT 0,
    cri_r5_f7 integer DEFAULT 0,
    cri_r5_f8 integer DEFAULT 0,
    cri_r5_f9 integer DEFAULT 0,
    cri_r5_f10 integer DEFAULT 0,
    cri_r5_f11 integer DEFAULT 0,
    cri_r5_f12 integer DEFAULT 0,
    cri_r5_f13 integer DEFAULT 0,
    cri_r5_f14 integer DEFAULT 0,
    cri_r6_f1 integer DEFAULT 0,
    cri_r6_f2 integer DEFAULT 0,
    cri_r6_f3 integer DEFAULT 0,
    cri_r6_f4 integer DEFAULT 0,
    cri_r6_f5 integer DEFAULT 0,
    cri_r6_f6 integer DEFAULT 0,
    cri_r6_f7 integer DEFAULT 0,
    cri_r6_f8 integer DEFAULT 0,
    cri_r6_f9 integer DEFAULT 0,
    cri_r6_f10 integer DEFAULT 0,
    cri_r6_f11 integer DEFAULT 0,
    cri_r6_f12 integer DEFAULT 0,
    cri_r6_f13 integer DEFAULT 0,
    cri_r6_f14 integer DEFAULT 0,
    cri_r7_f1 integer DEFAULT 0,
    cri_r7_f2 integer DEFAULT 0,
    cri_r7_f3 integer DEFAULT 0,
    cri_r7_f4 integer DEFAULT 0,
    cri_r7_f5 integer DEFAULT 0,
    cri_r7_f6 integer DEFAULT 0,
    cri_r7_f7 integer DEFAULT 0,
    cri_r7_f8 integer DEFAULT 0,
    cri_r7_f9 integer DEFAULT 0,
    cri_r7_f10 integer DEFAULT 0,
    cri_r7_f11 integer DEFAULT 0,
    cri_r7_f12 integer DEFAULT 0,
    cri_r7_f13 integer DEFAULT 0,
    cri_r7_f14 integer DEFAULT 0,
    cri_r8_f1 integer DEFAULT 0,
    cri_r8_f2 integer DEFAULT 0,
    cri_r8_f3 integer DEFAULT 0,
    cri_r8_f4 integer DEFAULT 0,
    cri_r8_f5 integer DEFAULT 0,
    cri_r8_f6 integer DEFAULT 0,
    cri_r8_f7 integer DEFAULT 0,
    cri_r8_f8 integer DEFAULT 0,
    cri_r8_f9 integer DEFAULT 0,
    cri_r8_f10 integer DEFAULT 0,
    cri_r8_f11 integer DEFAULT 0,
    cri_r8_f12 integer DEFAULT 0,
    cri_r8_f13 integer DEFAULT 0,
    cri_r8_f14 integer DEFAULT 0,
    cri_r9_f1 integer DEFAULT 0,
    cri_r9_f2 integer DEFAULT 0,
    cri_r9_f3 integer DEFAULT 0,
    cri_r9_f4 integer DEFAULT 0,
    cri_r9_f5 integer DEFAULT 0,
    cri_r9_f6 integer DEFAULT 0,
    cri_r9_f7 integer DEFAULT 0,
    cri_r9_f8 integer DEFAULT 0,
    cri_r9_f9 integer DEFAULT 0,
    cri_r9_f10 integer DEFAULT 0,
    cri_r9_f11 integer DEFAULT 0,
    cri_r9_f12 integer DEFAULT 0,
    cri_r9_f13 integer DEFAULT 0,
    cri_r9_f14 integer DEFAULT 0,
    cri_r10_f1 integer DEFAULT 0,
    cri_r10_f2 integer DEFAULT 0,
    cri_r10_f3 integer DEFAULT 0,
    cri_r10_f4 integer DEFAULT 0,
    cri_r10_f7 integer DEFAULT 0,
    cri_r10_f8 integer DEFAULT 0,
    cri_r10_f9 integer DEFAULT 0,
    cri_r10_f10 integer DEFAULT 0,
    cri_r10_f11 integer DEFAULT 0,
    cri_r10_f12 integer DEFAULT 0,
    cri_r10_f13 integer DEFAULT 0,
    cri_r10_f14 integer DEFAULT 0,
    cri_r11_f1 integer DEFAULT 0,
    cri_r11_f2 integer DEFAULT 0,
    cri_r11_f3 integer DEFAULT 0,
    cri_r11_f4 integer DEFAULT 0,
    cri_r11_f7 integer DEFAULT 0,
    cri_r11_f8 integer DEFAULT 0,
    cri_r11_f9 integer DEFAULT 0,
    cri_r11_f10 integer DEFAULT 0,
    cri_r11_f11 integer DEFAULT 0,
    cri_r11_f12 integer DEFAULT 0,
    cri_r11_f13 integer DEFAULT 0,
    cri_r11_f14 integer DEFAULT 0,
    cri_r12_f1 integer DEFAULT 0,
    cri_r12_f2 integer DEFAULT 0,
    cri_r12_f3 integer DEFAULT 0,
    cri_r12_f4 integer DEFAULT 0,
    cri_r12_f7 integer DEFAULT 0,
    cri_r12_f8 integer DEFAULT 0,
    cri_r12_f9 integer DEFAULT 0,
    cri_r12_f10 integer DEFAULT 0,
    cri_r12_f11 integer DEFAULT 0,
    cri_r12_f12 integer DEFAULT 0,
    cri_r12_f13 integer DEFAULT 0,
    cri_r12_f14 integer DEFAULT 0,
    cri_r13_f1 integer DEFAULT 0,
    cri_r13_f2 integer DEFAULT 0,
    cri_r13_f3 integer DEFAULT 0,
    cri_r13_f4 integer DEFAULT 0,
    cri_r13_f5 integer DEFAULT 0,
    cri_r13_f6 integer DEFAULT 0,
    cri_r13_f7 integer DEFAULT 0,
    cri_r13_f8 integer DEFAULT 0,
    cri_r13_f9 integer DEFAULT 0,
    cri_r13_f10 integer DEFAULT 0,
    cri_r13_f11 integer DEFAULT 0,
    cri_r13_f12 integer DEFAULT 0,
    cri_r13_f13 integer DEFAULT 0,
    cri_r13_f14 integer DEFAULT 0,
    cri_r14_f1 integer DEFAULT 0,
    cri_r14_f2 integer DEFAULT 0,
    cri_r14_f3 integer DEFAULT 0,
    cri_r14_f4 integer DEFAULT 0,
    cri_r14_f5 integer DEFAULT 0,
    cri_r14_f6 integer DEFAULT 0,
    cri_r14_f7 integer DEFAULT 0,
    cri_r14_f8 integer DEFAULT 0,
    cri_r14_f9 integer DEFAULT 0,
    cri_r14_f10 integer DEFAULT 0,
    cri_r14_f11 integer DEFAULT 0,
    cri_r14_f12 integer DEFAULT 0,
    cri_r14_f13 integer DEFAULT 0,
    cri_r14_f14 integer DEFAULT 0,
    cri_r15_f3 integer DEFAULT 0,
    cri_r15_f4 integer DEFAULT 0,
    cri_r15_f5 integer DEFAULT 0,
    cri_r15_f6 integer DEFAULT 0,
    cri_r15_f7 integer DEFAULT 0,
    cri_r15_f8 integer DEFAULT 0,
    cri_r15_f11 integer DEFAULT 0,
    cri_r15_f12 integer DEFAULT 0,
    cri_r15_f13 integer DEFAULT 0,
    cri_r15_f14 integer DEFAULT 0,
    ttri_r1_f1 integer DEFAULT 0,
    ttri_r1_f2 integer DEFAULT 0,
    ttri_r1_f3 integer DEFAULT 0,
    ttri_r1_f4 integer DEFAULT 0,
    ttri_r1_f5 integer DEFAULT 0,
    ttri_r1_f6 integer DEFAULT 0,
    ttri_r2_f1 integer DEFAULT 0,
    ttri_r2_f2 integer DEFAULT 0,
    ttri_r2_f3 integer DEFAULT 0,
    ttri_r2_f4 integer DEFAULT 0,
    ttri_r2_f5 integer DEFAULT 0,
    ttri_r2_f6 integer DEFAULT 0,
    ttri_r3_f1 integer DEFAULT 0,
    ttri_r3_f2 integer DEFAULT 0,
    ttri_r3_f3 integer DEFAULT 0,
    ttri_r3_f4 integer DEFAULT 0,
    ttri_r3_f5 integer DEFAULT 0,
    ttri_r3_f6 integer DEFAULT 0,
    ttri_r4_f1 integer DEFAULT 0,
    ttri_r4_f2 integer DEFAULT 0,
    ttri_r4_f3 integer DEFAULT 0,
    ttri_r4_f4 integer DEFAULT 0,
    ttri_r4_f5 integer DEFAULT 0,
    ttri_r4_f6 integer DEFAULT 0,
    ttri_r5_f1 integer DEFAULT 0,
    ttri_r5_f2 integer DEFAULT 0,
    ttri_r5_f3 integer DEFAULT 0,
    ttri_r5_f4 integer DEFAULT 0,
    ttri_r5_f5 integer DEFAULT 0,
    ttri_r5_f6 integer DEFAULT 0,
    vw_r1_f1 integer DEFAULT 0,
    vw_r1_f2 integer DEFAULT 0,
    vw_r1_f3 integer DEFAULT 0,
    vw_r1_f4 double precision DEFAULT 0,
    vw_r1_f5 integer DEFAULT 0,
    vw_r1_f6 integer DEFAULT 0,
    vw_r1_f7 integer DEFAULT 0,
    vw_r1_f8 double precision DEFAULT 0,
    vw_r2_f1 integer DEFAULT 0,
    vw_r2_f2 integer DEFAULT 0,
    vw_r2_f3 integer DEFAULT 0,
    vw_r2_f4 double precision DEFAULT 0,
    vw_r2_f5 integer DEFAULT 0,
    vw_r2_f6 integer DEFAULT 0,
    vw_r2_f7 integer DEFAULT 0,
    vw_r2_f8 double precision DEFAULT 0,
    vw_r3_f1 integer DEFAULT 0,
    vw_r3_f2 integer DEFAULT 0,
    vw_r3_f3 integer DEFAULT 0,
    vw_r3_f4 double precision DEFAULT 0,
    vw_r3_f5 integer DEFAULT 0,
    vw_r3_f6 integer DEFAULT 0,
    vw_r3_f7 integer DEFAULT 0,
    vw_r3_f8 double precision DEFAULT 0,
    vw_r4_f1 integer DEFAULT 0,
    vw_r4_f2 integer DEFAULT 0,
    vw_r4_f3 integer DEFAULT 0,
    vw_r4_f4 double precision DEFAULT 0,
    vw_r4_f5 integer DEFAULT 0,
    vw_r4_f6 integer DEFAULT 0,
    vw_r4_f7 integer DEFAULT 0,
    vw_r4_f8 double precision DEFAULT 0,
    vw_r5_f1 integer DEFAULT 0,
    vw_r5_f2 integer DEFAULT 0,
    vw_r5_f3 integer DEFAULT 0,
    vw_r5_f4 double precision DEFAULT 0,
    vw_r5_f5 integer DEFAULT 0,
    vw_r5_f6 integer DEFAULT 0,
    vw_r5_f7 integer DEFAULT 0,
    vw_r5_f8 double precision DEFAULT 0,
    vw_r6_f1 integer DEFAULT 0,
    vw_r6_f2 integer DEFAULT 0,
    vw_r6_f3 integer DEFAULT 0,
    vw_r6_f4 double precision DEFAULT 0,
    vw_r6_f5 integer DEFAULT 0,
    vw_r6_f6 integer DEFAULT 0,
    vw_r6_f7 integer DEFAULT 0,
    vw_r6_f8 double precision DEFAULT 0,
    vw_r7_f1 integer DEFAULT 0,
    vw_r7_f2 integer DEFAULT 0,
    vw_r7_f3 integer DEFAULT 0,
    vw_r7_f4 double precision DEFAULT 0,
    vw_r7_f5 integer DEFAULT 0,
    vw_r7_f6 integer DEFAULT 0,
    vw_r7_f7 integer DEFAULT 0,
    vw_r7_f8 double precision DEFAULT 0,
    vw_r8_f1 integer DEFAULT 0,
    vw_r8_f2 integer DEFAULT 0,
    vw_r8_f3 integer DEFAULT 0,
    vw_r8_f4 double precision DEFAULT 0,
    vw_r8_f5 integer DEFAULT 0,
    vw_r8_f6 integer DEFAULT 0,
    vw_r8_f7 integer DEFAULT 0,
    vw_r8_f8 double precision DEFAULT 0,
    fvw_r1_f1 integer DEFAULT 0,
    fvw_r1_f2 integer DEFAULT 0,
    fvw_r1_f3 integer DEFAULT 0,
    fvw_r1_f4 integer DEFAULT 0,
    fvw_r1_f5 integer DEFAULT 0,
    fvw_r1_f6 double precision DEFAULT 0,
    fvw_r1_f7 integer DEFAULT 0,
    fvw_r2_f1 integer DEFAULT 0,
    fvw_r2_f2 integer DEFAULT 0,
    fvw_r2_f3 integer DEFAULT 0,
    fvw_r2_f4 integer DEFAULT 0,
    fvw_r2_f5 integer DEFAULT 0,
    fvw_r2_f6 double precision DEFAULT 0,
    fvw_r2_f7 integer DEFAULT 0,
    fvw_r3_f1 integer DEFAULT 0,
    fvw_r3_f2 integer DEFAULT 0,
    fvw_r3_f3 integer DEFAULT 0,
    fvw_r3_f4 integer DEFAULT 0,
    fvw_r3_f5 integer DEFAULT 0,
    fvw_r3_f6 double precision DEFAULT 0,
    fvw_r3_f7 integer DEFAULT 0,
    fvw_r4_f1 integer DEFAULT 0,
    fvw_r4_f2 integer DEFAULT 0,
    fvw_r4_f3 integer DEFAULT 0,
    fvw_r4_f4 integer DEFAULT 0,
    fvw_r4_f5 integer DEFAULT 0,
    fvw_r4_f6 double precision DEFAULT 0,
    fvw_r4_f7 integer DEFAULT 0,
    fvw_r5_f1 integer DEFAULT 0,
    fvw_r5_f2 integer DEFAULT 0,
    fvw_r5_f3 integer DEFAULT 0,
    fvw_r5_f4 integer DEFAULT 0,
    fvw_r5_f5 integer DEFAULT 0,
    fvw_r5_f6 double precision DEFAULT 0,
    fvw_r5_f7 integer DEFAULT 0,
    fvw_r6_f1 integer DEFAULT 0,
    fvw_r6_f2 integer DEFAULT 0,
    fvw_r6_f3 integer DEFAULT 0,
    fvw_r6_f4 integer DEFAULT 0,
    fvw_r6_f5 integer DEFAULT 0,
    fvw_r6_f6 double precision DEFAULT 0,
    fvw_r6_f7 integer DEFAULT 0,
    fvw_r7_f1 integer DEFAULT 0,
    fvw_r7_f2 integer DEFAULT 0,
    fvw_r7_f3 integer DEFAULT 0,
    fvw_r7_f4 integer DEFAULT 0,
    fvw_r7_f5 integer DEFAULT 0,
    fvw_r7_f6 double precision DEFAULT 0,
    fvw_r7_f7 integer DEFAULT 0,
    fvw_r8_f1 integer DEFAULT 0,
    fvw_r8_f2 integer DEFAULT 0,
    fvw_r8_f3 integer DEFAULT 0,
    fvw_r8_f4 integer DEFAULT 0,
    fvw_r8_f5 integer DEFAULT 0,
    fvw_r8_f6 double precision DEFAULT 0,
    fvw_r8_f7 integer DEFAULT 0,
    submitted_date date,
    vacc_name text,
    lhsname character varying(40),
    incharge_name text,
    cri_r1_f3 integer DEFAULT 0,
    cri_r1_f4 integer DEFAULT 0,
    cri_r1_f5 integer DEFAULT 0,
    cri_r1_f6 integer DEFAULT 0,
    cri_r1_f11 integer DEFAULT 0,
    cri_r1_f12 integer DEFAULT 0,
    cri_r2_f3 integer DEFAULT 0,
    cri_r2_f4 integer DEFAULT 0,
    cri_r2_f5 integer DEFAULT 0,
    cri_r2_f6 integer DEFAULT 0,
    cri_r2_f11 integer DEFAULT 0,
    cri_r2_f12 integer DEFAULT 0,
    cri_r3_f3 integer DEFAULT 0,
    cri_r3_f4 integer DEFAULT 0,
    cri_r3_f5 integer DEFAULT 0,
    cri_r3_f6 integer DEFAULT 0,
    cri_r3_f11 integer DEFAULT 0,
    cri_r3_f12 integer DEFAULT 0,
    cri_r10_f5 integer DEFAULT 0,
    cri_r10_f6 integer DEFAULT 0,
    cri_r11_f5 integer DEFAULT 0,
    cri_r11_f6 integer DEFAULT 0,
    cri_r12_f5 integer DEFAULT 0,
    cri_r12_f6 integer DEFAULT 0,
    cri_r15_f1 integer DEFAULT 0,
    cri_r15_f2 integer DEFAULT 0,
    cri_r15_f9 integer DEFAULT 0,
    cri_r15_f10 integer DEFAULT 0
);


ALTER TABLE public.flcf_vacc_mr_old OWNER TO postgres;

--
-- Name: form_a1_fed_vaccine_columns_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE form_a1_fed_vaccine_columns_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1
    CYCLE;


ALTER TABLE public.form_a1_fed_vaccine_columns_seq OWNER TO postgres;

--
-- Name: form_a1_fed_vaccine_columns; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE form_a1_fed_vaccine_columns (
    id integer DEFAULT nextval('form_a1_fed_vaccine_columns_seq'::regclass) NOT NULL,
    manufacturer character varying(50),
    batch_no character varying(50),
    unitcost character varying(30),
    iq_vialsno character varying(20),
    iq_totaldoses character varying(30),
    rq_vialsno character varying(30),
    rq_totaldoses character varying(30),
    rq_vvmstage integer,
    iq_vvmstage integer,
    vaccine_id integer,
    main_id integer,
    expirydate character varying(7)
);


ALTER TABLE public.form_a1_fed_vaccine_columns OWNER TO postgres;

--
-- Name: form_a1_fed_vaccine_main_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE form_a1_fed_vaccine_main_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1
    CYCLE;


ALTER TABLE public.form_a1_fed_vaccine_main_seq OWNER TO postgres;

--
-- Name: form_a1_fed_vaccine_main; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE form_a1_fed_vaccine_main (
    id integer DEFAULT nextval('form_a1_fed_vaccine_main_seq'::regclass) NOT NULL,
    supply_store character varying(100),
    issued_store character varying(100),
    form_date date,
    distcode character varying(3),
    procode character varying(1),
    received_by character varying(100),
    received_by_desg character varying(100),
    received_by_store character varying(100),
    received_on date,
    other_name character varying(100)
);


ALTER TABLE public.form_a1_fed_vaccine_main OWNER TO postgres;

--
-- Name: form_a1_stock_issue_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE form_a1_stock_issue_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.form_a1_stock_issue_id_seq OWNER TO postgres;

--
-- Name: form_a1_stock; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE form_a1_stock (
    id integer DEFAULT nextval('form_a1_stock_issue_id_seq'::regclass) NOT NULL,
    supply_store character varying(100),
    issued_store character varying(100),
    form_date date,
    distcode character varying(3),
    procode character varying(1),
    sir_r1_f1 character varying(100),
    sir_r1_f2 character varying(25),
    sir_r1_f3 date,
    sir_r1_f4 double precision DEFAULT 0,
    sir_r1_f5 integer DEFAULT 0,
    sir_r1_f6 integer DEFAULT 0,
    sir_r1_f7 character varying(25),
    sir_r1_f8 integer DEFAULT 0,
    sir_r1_f9 integer DEFAULT 0,
    sir_r1_f10 character varying(25),
    sir_r2_f1 character varying(100),
    sir_r2_f2 character varying(25),
    sir_r2_f3 date,
    sir_r2_f4 double precision DEFAULT 0,
    sir_r2_f5 integer DEFAULT 0,
    sir_r2_f6 integer DEFAULT 0,
    sir_r2_f7 character varying(25),
    sir_r2_f8 integer DEFAULT 0,
    sir_r2_f9 integer DEFAULT 0,
    sir_r2_f10 character varying(25),
    sir_r3_f1 character varying(100),
    sir_r3_f2 character varying(25),
    sir_r3_f3 date,
    sir_r3_f4 double precision DEFAULT 0,
    sir_r3_f5 integer DEFAULT 0,
    sir_r3_f6 integer DEFAULT 0,
    sir_r3_f7 character varying(25),
    sir_r3_f8 integer DEFAULT 0,
    sir_r3_f9 integer DEFAULT 0,
    sir_r3_f10 character varying(25),
    sir_r4_f1 character varying(100),
    sir_r4_f2 character varying(25),
    sir_r4_f3 date,
    sir_r4_f4 double precision DEFAULT 0,
    sir_r4_f5 integer DEFAULT 0,
    sir_r4_f6 integer DEFAULT 0,
    sir_r4_f7 character varying(25),
    sir_r4_f8 integer DEFAULT 0,
    sir_r4_f9 integer DEFAULT 0,
    sir_r4_f10 character varying(25),
    sir_r5_f1 character varying(100),
    sir_r5_f2 character varying(25),
    sir_r5_f3 date,
    sir_r5_f4 double precision DEFAULT 0,
    sir_r5_f5 integer DEFAULT 0,
    sir_r5_f6 integer DEFAULT 0,
    sir_r5_f7 character varying(25),
    sir_r5_f8 integer DEFAULT 0,
    sir_r5_f9 integer DEFAULT 0,
    sir_r5_f10 character varying(25),
    sir_r6_f1 character varying(100),
    sir_r6_f2 character varying(25),
    sir_r6_f3 date,
    sir_r6_f4 double precision DEFAULT 0,
    sir_r6_f5 integer DEFAULT 0,
    sir_r6_f6 integer DEFAULT 0,
    sir_r6_f7 character varying(25),
    sir_r6_f8 integer DEFAULT 0,
    sir_r6_f9 integer DEFAULT 0,
    sir_r6_f10 character varying(25),
    sir_r7_f1 character varying(100),
    sir_r7_f2 character varying(25),
    sir_r7_f3 date,
    sir_r7_f4 double precision DEFAULT 0,
    sir_r7_f5 integer DEFAULT 0,
    sir_r7_f6 integer DEFAULT 0,
    sir_r7_f7 character varying(25),
    sir_r7_f8 integer DEFAULT 0,
    sir_r7_f9 integer DEFAULT 0,
    sir_r7_f10 character varying(25),
    sir_r8_f1 character varying(100),
    sir_r8_f2 character varying(25),
    sir_r8_f3 date,
    sir_r8_f4 double precision DEFAULT 0,
    sir_r8_f5 integer DEFAULT 0,
    sir_r8_f6 integer DEFAULT 0,
    sir_r8_f7 character varying(25),
    sir_r8_f8 integer DEFAULT 0,
    sir_r8_f9 integer DEFAULT 0,
    sir_r8_f10 character varying(25),
    sir_r9_f1 character varying(100),
    sir_r9_f2 character varying(25),
    sir_r9_f3 date,
    sir_r9_f4 double precision DEFAULT 0,
    sir_r9_f5 integer DEFAULT 0,
    sir_r9_f6 integer DEFAULT 0,
    sir_r9_f7 character varying(25),
    sir_r9_f8 integer DEFAULT 0,
    sir_r9_f9 integer DEFAULT 0,
    sir_r9_f10 character varying(25),
    sir_r10_f1 character varying(100),
    sir_r10_f2 character varying(25),
    sir_r10_f3 date,
    sir_r10_f4 double precision DEFAULT 0,
    sir_r10_f5 integer DEFAULT 0,
    sir_r10_f6 integer DEFAULT 0,
    sir_r10_f7 character varying(25),
    sir_r10_f8 integer DEFAULT 0,
    sir_r10_f9 integer DEFAULT 0,
    sir_r10_f10 character varying(25),
    sir_r11_f1 character varying(100),
    sir_r11_f2 character varying(25),
    sir_r11_f3 date,
    sir_r11_f4 double precision DEFAULT 0,
    sir_r11_f5 integer DEFAULT 0,
    sir_r11_f6 integer DEFAULT 0,
    sir_r11_f7 character varying(25),
    sir_r11_f8 integer DEFAULT 0,
    sir_r11_f9 integer DEFAULT 0,
    sir_r11_f10 character varying(25),
    sir_r12_f1 character varying(100),
    sir_r12_f2 character varying(25),
    sir_r12_f3 date,
    sir_r12_f4 double precision DEFAULT 0,
    sir_r12_f5 integer DEFAULT 0,
    sir_r12_f6 integer DEFAULT 0,
    sir_r12_f7 character varying(25),
    sir_r12_f8 integer DEFAULT 0,
    sir_r12_f9 integer DEFAULT 0,
    sir_r12_f10 character varying(25),
    sir_r13_f1 character varying(100),
    sir_r13_f2 character varying(25),
    sir_r13_f3 date,
    sir_r13_f4 double precision DEFAULT 0,
    sir_r13_f5 integer DEFAULT 0,
    sir_r13_f6 integer DEFAULT 0,
    sir_r13_f7 character varying(25),
    sir_r13_f8 integer DEFAULT 0,
    sir_r13_f9 integer DEFAULT 0,
    sir_r13_f10 character varying(25),
    sir_r14_f1 character varying(100),
    sir_r14_f2 character varying(25),
    sir_r14_f3 date,
    sir_r14_f4 double precision DEFAULT 0,
    sir_r14_f5 integer DEFAULT 0,
    sir_r14_f6 integer DEFAULT 0,
    sir_r14_f7 character varying(25),
    sir_r14_f8 integer DEFAULT 0,
    sir_r14_f9 integer DEFAULT 0,
    sir_r14_f10 character varying(25),
    sir_r15_f1 character varying(100),
    sir_r15_f2 character varying(25),
    sir_r15_f3 date,
    sir_r15_f4 double precision DEFAULT 0,
    sir_r15_f5 integer DEFAULT 0,
    sir_r15_f6 integer DEFAULT 0,
    sir_r15_f7 character varying(25),
    sir_r15_f8 integer DEFAULT 0,
    sir_r15_f9 integer DEFAULT 0,
    sir_r15_f10 character varying(25),
    sir_r16_f1 character varying(100),
    sir_r16_f2 character varying(25),
    sir_r16_f3 date,
    sir_r16_f4 double precision DEFAULT 0,
    sir_r16_f5 integer DEFAULT 0,
    sir_r16_f6 integer DEFAULT 0,
    sir_r16_f7 character varying(25),
    sir_r16_f8 integer DEFAULT 0,
    sir_r16_f9 integer DEFAULT 0,
    sir_r16_f10 character varying(25),
    sir_r17_f1 character varying(100),
    sir_r17_f2 character varying(25),
    sir_r17_f3 date,
    sir_r17_f4 double precision DEFAULT 0,
    sir_r17_f5 integer DEFAULT 0,
    sir_r17_f6 integer DEFAULT 0,
    sir_r17_f7 character varying(25),
    sir_r17_f8 integer DEFAULT 0,
    sir_r17_f9 integer DEFAULT 0,
    sir_r17_f10 character varying(25),
    issued_by_name character varying(100),
    issued_by_desg character varying(50),
    issued_by_store character varying(100),
    issued_on date,
    received_by_name character varying(100),
    received_by_desg character varying(50),
    received_by_store character varying(100),
    received_on date,
    other_name character varying(100),
    sir_r18_f1 character varying(100),
    sir_r18_f2 character varying(25),
    sir_r18_f3 date,
    sir_r18_f4 double precision DEFAULT 0,
    sir_r18_f5 integer DEFAULT 0,
    sir_r18_f6 integer DEFAULT 0,
    sir_r18_f7 character varying(25),
    sir_r18_f8 integer DEFAULT 0,
    sir_r18_f9 integer DEFAULT 0,
    sir_r18_f10 character varying(25)
);


ALTER TABLE public.form_a1_stock OWNER TO postgres;

--
-- Name: form_a1_vaccine_columns_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE form_a1_vaccine_columns_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.form_a1_vaccine_columns_seq OWNER TO postgres;



--
-- Name: form_a1_vaccine_columns; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE form_a1_vaccine_columns (
    id integer DEFAULT nextval('form_a1_vaccine_columns_seq'::regclass) NOT NULL,
    manufacturer character varying(50),
    batch_no character varying(50),
    unit_cost character varying(30),
    issue_quantity_vial_no character varying(20),
    issue_quantity_total_doses character varying(30),
    receive_quantity_vial_no character varying(30),
    receive_quantity_total_doses character varying(30),
    rq_vvmstage integer,
    iq_vvmstage integer,
    main_id integer,
    vaccine_id integer,
    expiry_date character varying(10)
);


ALTER TABLE public.form_a1_vaccine_columns OWNER TO postgres;

--
-- Name: form_a1_vaccine_main_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE form_a1_vaccine_main_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.form_a1_vaccine_main_seq OWNER TO postgres;

--
-- Name: form_a1_vaccine_main; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE form_a1_vaccine_main (
    id integer DEFAULT nextval('form_a1_vaccine_main_seq'::regclass) NOT NULL,
    supply_store character varying(100),
    issued_store character varying(100),
    form_date date,
    distcode character varying(3),
    procode character varying(1),
    issued_by_name character varying(100),
    issued_by_desg character varying(100),
    issued_by_store character varying(100),
    issued_on date,
    received_by_desg character varying(100),
    received_by_store character varying(100),
    received_on date,
    other_name character varying(100),
    receive_by character varying(100),
    status character varying(10),
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL
);


ALTER TABLE public.form_a1_vaccine_main OWNER TO postgres;

--
-- Name: COLUMN form_a1_vaccine_main.is_temp_saved; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN form_a1_vaccine_main.is_temp_saved IS '0 means form is completely filled and saved from submit button, 1 means checklist is not completed and temporarily saved for re-edit later';


--
-- Name: form_a1_vaccine_titles_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE form_a1_vaccine_titles_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1
    CYCLE;


ALTER TABLE public.form_a1_vaccine_titles_seq OWNER TO postgres;

--
-- Name: form_a1_vaccine_titles; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE form_a1_vaccine_titles (
    id integer DEFAULT nextval('form_a1_vaccine_titles_seq'::regclass) NOT NULL,
    vaccine_name character varying(100),
    doses_per_vial integer,
    form_name character varying(2),
    vaccine_cost double precision DEFAULT 0
);


ALTER TABLE public.form_a1_vaccine_titles OWNER TO postgres;

--
-- Name: form_a2_new_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE form_a2_new_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1
    CYCLE;


ALTER TABLE public.form_a2_new_seq OWNER TO postgres;



--
-- Name: form_a2_new; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE form_a2_new (
    id integer DEFAULT nextval('form_a2_new_seq'::regclass) NOT NULL,
    campaign_type character varying(100),
    uncode character varying(9),
    distcode character varying(3),
    procode character varying(1),
    form_date date,
    vaccine_type integer,
    doses_per_vial double precision DEFAULT 0,
    manufacturer character varying(50),
    batch_no character varying(50),
    iq_vialsno character varying(20),
    iq_totaldoses character varying(50),
    rq_vialsno character varying(50),
    rq_totaldoses character varying(50),
    rq_vvmstage integer,
    iq_vvmstage integer,
    expirydate character varying(10),
    supply_store character varying(100),
    issued_by_name character varying(100),
    issued_store character varying(100),
    issued_by_desg character varying(100),
    issued_by_store character varying(100),
    issued_on date,
    received_by_desg character varying(100),
    received_by_store character varying(100),
    received_on date,
    receive_by character varying(100),
    facode character varying(6),
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    group_id integer,
    othername double precision DEFAULT 0,
    report_submitted integer DEFAULT 0
);


ALTER TABLE public.form_a2_new OWNER TO postgres;

--
-- Name: form_a2_stock_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE form_a2_stock_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.form_a2_stock_id_seq OWNER TO postgres;

--
-- Name: form_a2_stock; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE form_a2_stock (
    id integer DEFAULT nextval('form_a2_stock_id_seq'::regclass) NOT NULL,
    campaign_type character varying(30),
    supply_store character varying(50),
    issued_store character varying(50),
    form_date date,
    sir_r1_f1 character varying(30),
    sir_r1_f2 character varying(15),
    sir_r1_f3 date,
    sir_r1_f4 integer DEFAULT 0,
    sir_r1_f5 integer DEFAULT 0,
    sir_r1_f6 character varying(15),
    sir_r1_f7 integer DEFAULT 0,
    sir_r1_f8 integer DEFAULT 0,
    sir_r1_f9 character varying(15),
    sir_r2_f1 character varying(30),
    sir_r2_f2 character varying(15),
    sir_r2_f3 date,
    sir_r2_f4 integer DEFAULT 0,
    sir_r2_f5 integer DEFAULT 0,
    sir_r2_f6 character varying(15),
    sir_r2_f7 integer DEFAULT 0,
    sir_r2_f8 integer DEFAULT 0,
    sir_r2_f9 character varying(15),
    sir_r3_f1 character varying(30),
    sir_r3_f2 character varying(15),
    sir_r3_f3 date,
    sir_r3_f4 integer DEFAULT 0,
    sir_r3_f5 integer DEFAULT 0,
    sir_r3_f6 character varying(15),
    sir_r3_f7 integer DEFAULT 0,
    sir_r3_f8 integer DEFAULT 0,
    sir_r3_f9 character varying(15),
    sir_r4_f1 character varying(30),
    sir_r4_f2 character varying(15),
    sir_r4_f3 date,
    sir_r4_f4 integer DEFAULT 0,
    sir_r4_f5 integer DEFAULT 0,
    sir_r4_f6 character varying(15),
    sir_r4_f7 integer DEFAULT 0,
    sir_r4_f8 integer DEFAULT 0,
    sir_r4_f9 character varying(15),
    sir_r5_f1 character varying(30),
    sir_r5_f2 character varying(15),
    sir_r5_f3 date,
    sir_r5_f4 integer DEFAULT 0,
    sir_r5_f5 integer DEFAULT 0,
    sir_r5_f6 character varying(15),
    sir_r5_f7 integer DEFAULT 0,
    sir_r5_f8 integer DEFAULT 0,
    sir_r5_f9 character varying(15),
    sir_r6_f1 character varying(30),
    sir_r6_f2 character varying(15),
    sir_r6_f3 date,
    sir_r6_f4 integer DEFAULT 0,
    sir_r6_f5 integer DEFAULT 0,
    sir_r6_f6 character varying(15),
    sir_r6_f7 integer DEFAULT 0,
    sir_r6_f8 integer DEFAULT 0,
    sir_r6_f9 character varying(15),
    sir_r7_f1 character varying(30),
    sir_r7_f2 character varying(15),
    sir_r7_f3 date,
    sir_r7_f4 integer DEFAULT 0,
    sir_r7_f5 integer DEFAULT 0,
    sir_r7_f6 character varying(15),
    sir_r7_f7 integer DEFAULT 0,
    sir_r7_f8 integer DEFAULT 0,
    sir_r7_f9 character varying(15),
    sir_r8_f1 character varying(30),
    sir_r8_f2 character varying(15),
    sir_r8_f3 date,
    sir_r8_f4 integer DEFAULT 0,
    sir_r8_f5 integer DEFAULT 0,
    sir_r8_f6 character varying(15),
    sir_r8_f7 integer DEFAULT 0,
    sir_r8_f8 integer DEFAULT 0,
    sir_r8_f9 character varying(15),
    sir_r9_f1 character varying(30),
    sir_r9_f2 character varying(15),
    sir_r9_f3 date,
    sir_r9_f4 integer DEFAULT 0,
    sir_r9_f5 integer DEFAULT 0,
    sir_r9_f6 character varying(15),
    sir_r9_f7 integer DEFAULT 0,
    sir_r9_f8 integer DEFAULT 0,
    sir_r9_f9 character varying(15),
    sir_r10_f1 character varying(30),
    sir_r10_f2 character varying(15),
    sir_r10_f3 date,
    sir_r10_f4 integer DEFAULT 0,
    sir_r10_f5 integer DEFAULT 0,
    sir_r10_f6 character varying(15),
    sir_r10_f7 integer DEFAULT 0,
    sir_r10_f8 integer DEFAULT 0,
    sir_r10_f9 character varying(15),
    issued_by_name character varying(50),
    issued_by_desg character varying(30),
    issued_by_store character varying(30),
    issued_on date,
    received_by_name character varying(50),
    received_by_desg character varying(30),
    received_by_store character varying(30),
    received_on date,
    other_name character varying(100),
    distcode character varying(3),
    facode character varying(6),
    procode character varying(1) DEFAULT 3
);


ALTER TABLE public.form_a2_stock OWNER TO postgres;

--
-- Name: form_a2_vaccine_columns; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE form_a2_vaccine_columns (
    id integer DEFAULT nextval('form_a1_fed_vaccine_columns_seq'::regclass) NOT NULL,
    manufacturer character varying(50),
    batch_no character varying(50),
    iq_vialsno character varying(20),
    iq_totaldoses character varying(30),
    rq_vialsno character varying(30),
    rq_totaldoses character varying(30),
    rq_vvmstage integer,
    iq_vvmstage integer,
    vaccine_id integer,
    main_id integer,
    expirydate date
);


ALTER TABLE public.form_a2_vaccine_columns OWNER TO postgres;

--
-- Name: form_a2_vaccine_main_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE form_a2_vaccine_main_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1
    CYCLE;


ALTER TABLE public.form_a2_vaccine_main_seq OWNER TO postgres;

--
-- Name: form_a2_vaccine_main; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE form_a2_vaccine_main (
    id integer DEFAULT nextval('form_a2_vaccine_main_seq'::regclass) NOT NULL,
    supply_store character varying(100),
    issued_store character varying(100),
    form_date date,
    distcode character varying(3),
    procode character varying(1),
    issued_by_name character varying(100),
    issued_by_desg character varying(100),
    issued_by_store character varying(100),
    issued_on date,
    received_by_desg character varying(100),
    received_by_store character varying(100),
    received_on date,
    campaign_type character varying(100),
    receive_by character varying(100),
    facode character varying(6),
    tcode character varying(6),
    uncode character varying(9),
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL
);


ALTER TABLE public.form_a2_vaccine_main OWNER TO postgres;

--
-- Name: COLUMN form_a2_vaccine_main.is_temp_saved; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN form_a2_vaccine_main.is_temp_saved IS '0 means form is completely filled and saved from submit button, 1 means checklist is not completed and temporarily saved for re-edit later';


--
-- Name: form_b_cr_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE form_b_cr_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.form_b_cr_id_seq OWNER TO postgres;

--
-- Name: form_b_cr; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE form_b_cr (
    id integer DEFAULT nextval('form_b_cr_id_seq'::regclass) NOT NULL,
    facode character varying(6),
    uncode character varying(9),
    tcode character varying(6),
    distcode character varying(3),
    procode character varying(1),
    cr_r1_f1 integer DEFAULT 0,
    cr_r1_f2 integer DEFAULT 0,
    cr_r1_f3 integer DEFAULT 0,
    cr_r1_f4 integer DEFAULT 0,
    cr_r1_f5 integer DEFAULT 0,
    cr_r1_f6 integer DEFAULT 0,
    cr_r2_f1 integer DEFAULT 0,
    cr_r2_f2 integer DEFAULT 0,
    cr_r2_f3 integer DEFAULT 0,
    cr_r2_f4 integer DEFAULT 0,
    cr_r2_f5 integer DEFAULT 0,
    cr_r2_f6 integer DEFAULT 0,
    cr_r3_f1 integer DEFAULT 0,
    cr_r3_f2 integer DEFAULT 0,
    cr_r3_f3 integer DEFAULT 0,
    cr_r3_f4 integer DEFAULT 0,
    cr_r3_f5 integer DEFAULT 0,
    cr_r3_f6 integer DEFAULT 0,
    cr_r4_f1 integer DEFAULT 0,
    cr_r4_f2 integer DEFAULT 0,
    cr_r4_f3 integer DEFAULT 0,
    cr_r4_f4 integer DEFAULT 0,
    cr_r4_f5 integer DEFAULT 0,
    cr_r4_f6 integer DEFAULT 0,
    cr_r5_f1 integer DEFAULT 0,
    cr_r5_f2 integer DEFAULT 0,
    cr_r5_f3 integer DEFAULT 0,
    cr_r5_f4 integer DEFAULT 0,
    cr_r5_f5 integer DEFAULT 0,
    cr_r5_f6 integer DEFAULT 0,
    cr_r6_f1 integer DEFAULT 0,
    cr_r6_f2 integer DEFAULT 0,
    cr_r6_f3 integer DEFAULT 0,
    cr_r6_f4 integer DEFAULT 0,
    cr_r6_f5 integer DEFAULT 0,
    cr_r6_f6 integer DEFAULT 0,
    cr_r7_f1 integer DEFAULT 0,
    cr_r7_f2 integer DEFAULT 0,
    cr_r7_f3 integer DEFAULT 0,
    cr_r7_f4 integer DEFAULT 0,
    cr_r7_f5 integer DEFAULT 0,
    cr_r7_f6 integer DEFAULT 0,
    cr_r8_f1 integer DEFAULT 0,
    cr_r8_f2 integer DEFAULT 0,
    cr_r8_f3 integer DEFAULT 0,
    cr_r8_f4 integer DEFAULT 0,
    cr_r8_f5 integer DEFAULT 0,
    cr_r8_f6 integer DEFAULT 0,
    cr_r9_f1 integer DEFAULT 0,
    cr_r9_f2 integer DEFAULT 0,
    cr_r9_f3 integer DEFAULT 0,
    cr_r9_f4 integer DEFAULT 0,
    cr_r9_f5 integer DEFAULT 0,
    cr_r9_f6 integer DEFAULT 0,
    cr_r10_f1 integer DEFAULT 0,
    cr_r10_f2 integer DEFAULT 0,
    cr_r10_f3 integer DEFAULT 0,
    cr_r10_f4 integer DEFAULT 0,
    cr_r10_f5 integer DEFAULT 0,
    cr_r10_f6 integer DEFAULT 0,
    cr_r11_f1 integer DEFAULT 0,
    cr_r11_f2 integer DEFAULT 0,
    cr_r11_f3 integer DEFAULT 0,
    cr_r11_f4 integer DEFAULT 0,
    cr_r11_f5 integer DEFAULT 0,
    cr_r11_f6 integer DEFAULT 0,
    cr_r12_f1 integer DEFAULT 0,
    cr_r12_f2 integer DEFAULT 0,
    cr_r12_f3 integer DEFAULT 0,
    cr_r12_f4 integer DEFAULT 0,
    cr_r12_f5 integer DEFAULT 0,
    cr_r12_f6 integer DEFAULT 0,
    cr_r13_f1 integer DEFAULT 0,
    cr_r13_f2 integer DEFAULT 0,
    cr_r13_f3 integer DEFAULT 0,
    cr_r13_f4 integer DEFAULT 0,
    cr_r13_f5 integer DEFAULT 0,
    cr_r13_f6 integer DEFAULT 0,
    cr_r14_f1 integer DEFAULT 0,
    cr_r14_f2 integer DEFAULT 0,
    cr_r14_f3 integer DEFAULT 0,
    cr_r14_f4 integer DEFAULT 0,
    cr_r14_f5 integer DEFAULT 0,
    cr_r14_f6 integer DEFAULT 0,
    cr_r15_f1 integer DEFAULT 0,
    cr_r15_f2 integer DEFAULT 0,
    cr_r15_f3 integer DEFAULT 0,
    cr_r15_f4 integer DEFAULT 0,
    cr_r15_f5 integer DEFAULT 0,
    cr_r15_f6 integer DEFAULT 0,
    cr_r16_f1 integer DEFAULT 0,
    cr_r16_f2 integer DEFAULT 0,
    cr_r16_f3 integer DEFAULT 0,
    cr_r16_f4 integer DEFAULT 0,
    cr_r16_f5 integer DEFAULT 0,
    cr_r16_f6 integer DEFAULT 0,
    cr_r17_f1 integer DEFAULT 0,
    cr_r17_f2 integer DEFAULT 0,
    cr_r17_f3 integer DEFAULT 0,
    cr_r17_f4 integer DEFAULT 0,
    cr_r17_f5 integer DEFAULT 0,
    cr_r17_f6 integer DEFAULT 0,
    prepare_by character varying(100),
    incharge character varying(100),
    date_submitted date,
    fmonth character varying(7),
    cr_r18_f1 integer DEFAULT 0,
    cr_r18_f2 integer DEFAULT 0,
    cr_r18_f3 integer DEFAULT 0,
    cr_r18_f4 integer DEFAULT 0,
    cr_r18_f5 integer DEFAULT 0,
    cr_r18_f6 integer DEFAULT 0,
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    year character varying(4),
    month character varying(2),
    cr_r19_f1 integer DEFAULT 0,
    cr_r19_f2 integer DEFAULT 0,
    cr_r19_f3 integer DEFAULT 0,
    cr_r19_f4 integer DEFAULT 0,
    cr_r19_f5 integer DEFAULT 0,
    cr_r19_f6 integer DEFAULT 0,
    cr_r20_f1 integer DEFAULT 0,
    cr_r20_f2 integer DEFAULT 0,
    cr_r20_f3 integer DEFAULT 0,
    cr_r20_f4 integer DEFAULT 0,
    cr_r20_f5 integer DEFAULT 0,
    cr_r20_f6 integer DEFAULT 0,
    cr_r21_f1 integer DEFAULT 0,
    cr_r21_f2 integer DEFAULT 0,
    cr_r21_f3 integer DEFAULT 0,
    cr_r21_f4 integer DEFAULT 0,
    cr_r21_f5 integer DEFAULT 0,
    cr_r21_f6 integer DEFAULT 0,
    cr_r22_f1 integer DEFAULT 0,
    cr_r22_f2 integer DEFAULT 0,
    cr_r22_f3 integer DEFAULT 0,
    cr_r22_f4 integer DEFAULT 0,
    cr_r22_f5 integer DEFAULT 0,
    cr_r22_f6 integer DEFAULT 0,
    cr_r23_f1 integer DEFAULT 0,
    cr_r23_f2 integer DEFAULT 0,
    cr_r23_f3 integer DEFAULT 0,
    cr_r23_f4 integer DEFAULT 0,
    cr_r23_f5 integer DEFAULT 0,
    cr_r23_f6 integer DEFAULT 0,
    cr_r24_f1 integer DEFAULT 0,
    cr_r24_f2 integer DEFAULT 0,
    cr_r24_f3 integer DEFAULT 0,
    cr_r24_f4 integer DEFAULT 0,
    cr_r24_f5 integer DEFAULT 0,
    cr_r24_f6 integer DEFAULT 0,
    cr_r25_f1 integer DEFAULT 0,
    cr_r25_f2 integer DEFAULT 0,
    cr_r25_f3 integer DEFAULT 0,
    cr_r25_f4 integer DEFAULT 0,
    cr_r25_f5 integer DEFAULT 0,
    cr_r25_f6 integer DEFAULT 0
);


ALTER TABLE public.form_b_cr OWNER TO postgres;

--
-- Name: COLUMN form_b_cr.is_temp_saved; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN form_b_cr.is_temp_saved IS '0 means form is completely filled and saved from submit button, 1 means checklist is not completed and temporarily saved for re-edit later';


--
-- Name: form_b_cr_id_seq_new; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE form_b_cr_id_seq_new
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999999
    CACHE 1
    CYCLE;


ALTER TABLE public.form_b_cr_id_seq_new OWNER TO postgres;

--
-- Name: form_b_cr_p; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE form_b_cr_p (
    id integer DEFAULT nextval('form_b_cr_id_seq'::regclass) NOT NULL,
    facode character varying(6),
    uncode character varying(9),
    tcode character varying(6),
    distcode character varying(3),
    procode character varying(1),
    cr_r1_f1 integer DEFAULT 0,
    cr_r1_f2 integer DEFAULT 0,
    cr_r1_f3 integer DEFAULT 0,
    cr_r1_f4 integer DEFAULT 0,
    cr_r1_f5 integer DEFAULT 0,
    cr_r1_f6 integer DEFAULT 0,
    cr_r2_f1 integer DEFAULT 0,
    cr_r2_f2 integer DEFAULT 0,
    cr_r2_f3 integer DEFAULT 0,
    cr_r2_f4 integer DEFAULT 0,
    cr_r2_f5 integer DEFAULT 0,
    cr_r2_f6 integer DEFAULT 0,
    cr_r3_f1 integer DEFAULT 0,
    cr_r3_f2 integer DEFAULT 0,
    cr_r3_f3 integer DEFAULT 0,
    cr_r3_f4 integer DEFAULT 0,
    cr_r3_f5 integer DEFAULT 0,
    cr_r3_f6 integer DEFAULT 0,
    cr_r4_f1 integer DEFAULT 0,
    cr_r4_f2 integer DEFAULT 0,
    cr_r4_f3 integer DEFAULT 0,
    cr_r4_f4 integer DEFAULT 0,
    cr_r4_f5 integer DEFAULT 0,
    cr_r4_f6 integer DEFAULT 0,
    cr_r5_f1 integer DEFAULT 0,
    cr_r5_f2 integer DEFAULT 0,
    cr_r5_f3 integer DEFAULT 0,
    cr_r5_f4 integer DEFAULT 0,
    cr_r5_f5 integer DEFAULT 0,
    cr_r5_f6 integer DEFAULT 0,
    cr_r6_f1 integer DEFAULT 0,
    cr_r6_f2 integer DEFAULT 0,
    cr_r6_f3 integer DEFAULT 0,
    cr_r6_f4 integer DEFAULT 0,
    cr_r6_f5 integer DEFAULT 0,
    cr_r6_f6 integer DEFAULT 0,
    cr_r7_f1 integer DEFAULT 0,
    cr_r7_f2 integer DEFAULT 0,
    cr_r7_f3 integer DEFAULT 0,
    cr_r7_f4 integer DEFAULT 0,
    cr_r7_f5 integer DEFAULT 0,
    cr_r7_f6 integer DEFAULT 0,
    cr_r8_f1 integer DEFAULT 0,
    cr_r8_f2 integer DEFAULT 0,
    cr_r8_f3 integer DEFAULT 0,
    cr_r8_f4 integer DEFAULT 0,
    cr_r8_f5 integer DEFAULT 0,
    cr_r8_f6 integer DEFAULT 0,
    cr_r9_f1 integer DEFAULT 0,
    cr_r9_f2 integer DEFAULT 0,
    cr_r9_f3 integer DEFAULT 0,
    cr_r9_f4 integer DEFAULT 0,
    cr_r9_f5 integer DEFAULT 0,
    cr_r9_f6 integer DEFAULT 0,
    cr_r10_f1 integer DEFAULT 0,
    cr_r10_f2 integer DEFAULT 0,
    cr_r10_f3 integer DEFAULT 0,
    cr_r10_f4 integer DEFAULT 0,
    cr_r10_f5 integer DEFAULT 0,
    cr_r10_f6 integer DEFAULT 0,
    cr_r11_f1 integer DEFAULT 0,
    cr_r11_f2 integer DEFAULT 0,
    cr_r11_f3 integer DEFAULT 0,
    cr_r11_f4 integer DEFAULT 0,
    cr_r11_f5 integer DEFAULT 0,
    cr_r11_f6 integer DEFAULT 0,
    cr_r12_f1 integer DEFAULT 0,
    cr_r12_f2 integer DEFAULT 0,
    cr_r12_f3 integer DEFAULT 0,
    cr_r12_f4 integer DEFAULT 0,
    cr_r12_f5 integer DEFAULT 0,
    cr_r12_f6 integer DEFAULT 0,
    cr_r13_f1 integer DEFAULT 0,
    cr_r13_f2 integer DEFAULT 0,
    cr_r13_f3 integer DEFAULT 0,
    cr_r13_f4 integer DEFAULT 0,
    cr_r13_f5 integer DEFAULT 0,
    cr_r13_f6 integer DEFAULT 0,
    cr_r14_f1 integer DEFAULT 0,
    cr_r14_f2 integer DEFAULT 0,
    cr_r14_f3 integer DEFAULT 0,
    cr_r14_f4 integer DEFAULT 0,
    cr_r14_f5 integer DEFAULT 0,
    cr_r14_f6 integer DEFAULT 0,
    cr_r15_f1 integer DEFAULT 0,
    cr_r15_f2 integer DEFAULT 0,
    cr_r15_f3 integer DEFAULT 0,
    cr_r15_f4 integer DEFAULT 0,
    cr_r15_f5 integer DEFAULT 0,
    cr_r15_f6 integer DEFAULT 0,
    cr_r16_f1 integer DEFAULT 0,
    cr_r16_f2 integer DEFAULT 0,
    cr_r16_f3 integer DEFAULT 0,
    cr_r16_f4 integer DEFAULT 0,
    cr_r16_f5 integer DEFAULT 0,
    cr_r16_f6 integer DEFAULT 0,
    cr_r17_f1 integer DEFAULT 0,
    cr_r17_f2 integer DEFAULT 0,
    cr_r17_f3 integer DEFAULT 0,
    cr_r17_f4 integer DEFAULT 0,
    cr_r17_f5 integer DEFAULT 0,
    cr_r17_f6 integer DEFAULT 0,
    prepare_by character varying(100),
    incharge character varying(100),
    date_submitted date,
    fmonth character varying(7),
    cr_r18_f1 integer DEFAULT 0,
    cr_r18_f2 integer DEFAULT 0,
    cr_r18_f3 integer DEFAULT 0,
    cr_r18_f4 integer DEFAULT 0,
    cr_r18_f5 integer DEFAULT 0,
    cr_r18_f6 integer DEFAULT 0,
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    year character varying(4),
    month character varying(2),
    cr_r19_f1 integer DEFAULT 0,
    cr_r19_f2 integer DEFAULT 0,
    cr_r19_f3 integer DEFAULT 0,
    cr_r19_f4 integer DEFAULT 0,
    cr_r19_f5 integer DEFAULT 0,
    cr_r19_f6 integer DEFAULT 0,
    cr_r20_f1 integer DEFAULT 0,
    cr_r20_f2 integer DEFAULT 0,
    cr_r20_f3 integer DEFAULT 0,
    cr_r20_f4 integer DEFAULT 0,
    cr_r20_f5 integer DEFAULT 0,
    cr_r20_f6 integer DEFAULT 0
);


ALTER TABLE public.form_b_cr_p OWNER TO postgres;

--
-- Name: COLUMN form_b_cr_p.is_temp_saved; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN form_b_cr_p.is_temp_saved IS ' 	0 means form is completely filled and saved from submit button, 1 means checklist is not completed and temporarily saved for re-edit later';


--
-- Name: form_c_demand_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE form_c_demand_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.form_c_demand_id_seq OWNER TO postgres;

--
-- Name: form_c_demand; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE form_c_demand (
    id integer DEFAULT nextval('form_c_demand_id_seq'::regclass) NOT NULL,
    campaign_type character varying(30),
    uncode character varying(9),
    tcode character varying(6),
    distcode character varying(3),
    procode character varying(1),
    start_date date,
    end_date date,
    dcr_r1_f1 character varying(20),
    dcr_r1_f2 double precision DEFAULT 0,
    dcr_r1_f3 double precision DEFAULT 0,
    dcr_r1_f4 double precision DEFAULT 0,
    dcr_r1_f5 integer DEFAULT 0,
    dcr_r1_f6 double precision DEFAULT 0,
    dcr_r1_f7 integer DEFAULT 0,
    dcr_r1_f8 integer DEFAULT 0,
    dcr_r1_f9 integer DEFAULT 0,
    dcr_r1_f10 integer DEFAULT 0,
    dcr_r2_f1 character varying(20),
    dcr_r2_f2 double precision DEFAULT 0,
    dcr_r2_f3 double precision DEFAULT 0,
    dcr_r2_f4 double precision DEFAULT 0,
    dcr_r2_f5 double precision DEFAULT 0,
    dcr_r2_f6 double precision DEFAULT 0,
    dcr_r2_f7 integer DEFAULT 0,
    dcr_r2_f8 integer DEFAULT 0,
    dcr_r2_f9 integer DEFAULT 0,
    dcr_r2_f10 integer DEFAULT 0,
    dcr_r3_f1 character varying(20),
    dcr_r3_f2 double precision DEFAULT 0,
    dcr_r3_f3 double precision DEFAULT 0,
    dcr_r3_f4 double precision DEFAULT 0,
    dcr_r3_f5 integer DEFAULT 0,
    dcr_r3_f6 double precision DEFAULT 0,
    dcr_r3_f7 integer DEFAULT 0,
    dcr_r3_f8 integer DEFAULT 0,
    dcr_r3_f9 integer DEFAULT 0,
    dcr_r3_f10 integer DEFAULT 0,
    dcr_r4_f1 character varying(20),
    dcr_r4_f2 double precision DEFAULT 0,
    dcr_r4_f3 double precision DEFAULT 0,
    dcr_r4_f4 double precision DEFAULT 0,
    dcr_r4_f5 integer DEFAULT 0,
    dcr_r4_f6 double precision DEFAULT 0,
    dcr_r4_f7 integer DEFAULT 0,
    dcr_r4_f8 integer DEFAULT 0,
    dcr_r4_f9 integer DEFAULT 0,
    dcr_r4_f10 integer DEFAULT 0,
    dcr_r5_f1 character varying(20),
    dcr_r5_f2 double precision DEFAULT 0,
    dcr_r5_f3 double precision DEFAULT 0,
    dcr_r5_f4 double precision DEFAULT 0,
    dcr_r5_f5 integer DEFAULT 0,
    dcr_r5_f6 double precision DEFAULT 0,
    dcr_r5_f7 integer DEFAULT 0,
    dcr_r5_f8 integer DEFAULT 0,
    dcr_r5_f9 integer DEFAULT 0,
    dcr_r5_f10 integer DEFAULT 0,
    dcr_r6_f1 character varying(20),
    dcr_r6_f2 double precision DEFAULT 0,
    dcr_r6_f3 double precision DEFAULT 0,
    dcr_r6_f4 double precision DEFAULT 0,
    dcr_r6_f5 integer DEFAULT 0,
    dcr_r6_f6 double precision DEFAULT 0,
    dcr_r6_f7 integer DEFAULT 0,
    dcr_r6_f8 integer DEFAULT 0,
    dcr_r6_f9 integer DEFAULT 0,
    dcr_r6_f10 integer DEFAULT 0,
    dcr_r7_f1 character varying(20),
    dcr_r7_f2 double precision DEFAULT 0,
    dcr_r7_f3 integer DEFAULT 0,
    dcr_r7_f4 integer DEFAULT 0,
    dcr_r7_f5 integer DEFAULT 0,
    dcr_r7_f6 integer DEFAULT 0,
    dcr_r7_f7 integer DEFAULT 0,
    dcr_r7_f8 integer DEFAULT 0,
    dcr_r7_f9 integer DEFAULT 0,
    dcr_r7_f10 integer DEFAULT 0,
    dcr_r8_f1 character varying(20),
    dcr_r8_f2 double precision DEFAULT 0,
    dcr_r8_f3 integer DEFAULT 0,
    dcr_r8_f4 integer DEFAULT 0,
    dcr_r8_f5 integer DEFAULT 0,
    dcr_r8_f6 integer DEFAULT 0,
    dcr_r8_f7 integer DEFAULT 0,
    dcr_r8_f8 integer DEFAULT 0,
    dcr_r8_f9 integer DEFAULT 0,
    dcr_r8_f10 integer DEFAULT 0,
    dcr_r9_f1 character varying(20),
    dcr_r9_f2 double precision DEFAULT 0,
    dcr_r9_f3 integer DEFAULT 0,
    dcr_r9_f4 integer DEFAULT 0,
    dcr_r9_f5 integer DEFAULT 0,
    dcr_r9_f6 integer DEFAULT 0,
    dcr_r9_f7 integer DEFAULT 0,
    dcr_r9_f8 integer DEFAULT 0,
    dcr_r9_f9 integer DEFAULT 0,
    dcr_r9_f10 integer DEFAULT 0,
    dcr_r10_f1 character varying(20),
    dcr_r10_f2 double precision DEFAULT 0,
    dcr_r10_f3 double precision DEFAULT 0,
    dcr_r10_f4 double precision DEFAULT 0,
    dcr_r10_f5 double precision DEFAULT 0,
    dcr_r10_f6 double precision DEFAULT 0,
    dcr_r10_f7 integer DEFAULT 0,
    dcr_r10_f8 integer DEFAULT 0,
    dcr_r10_f9 integer DEFAULT 0,
    dcr_r10_f10 integer DEFAULT 0,
    requested_by_name character varying(50),
    requested_by_desg character varying(30),
    requested_by_store character varying(30),
    requested_on date,
    received_by_name character varying(50),
    received_by_desg character varying(30),
    received_by_store character varying(30),
    received_on date,
    reported_by_name character varying(50),
    reported_by_desg character varying(30),
    reported_by_store character varying(30),
    reported_on date,
    othername character varying(100),
    dcr_r1_f11 integer DEFAULT 0,
    dcr_r2_f11 integer DEFAULT 0,
    dcr_r3_f11 integer DEFAULT 0,
    dcr_r4_f11 integer DEFAULT 0,
    dcr_r5_f11 integer DEFAULT 0,
    dcr_r6_f11 integer DEFAULT 0,
    dcr_r7_f11 integer DEFAULT 0,
    dcr_r8_f11 integer DEFAULT 0,
    dcr_r9_f11 integer DEFAULT 0,
    dcr_r10_f11 integer DEFAULT 0,
    from_fmonth character varying(7),
    to_fmonth character varying(7),
    facode character varying(6),
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL
);


ALTER TABLE public.form_c_demand OWNER TO postgres;

--
-- Name: COLUMN form_c_demand.is_temp_saved; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN form_c_demand.is_temp_saved IS '0 means form is completely filled and saved from submit button, 1 means checklist is not completed and temporarily saved for re-edit later';


--
-- Name: form_c_new_demand_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE form_c_new_demand_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1
    CYCLE;


ALTER TABLE public.form_c_new_demand_id_seq OWNER TO postgres;

--
-- Name: form_c_new_demand; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE form_c_new_demand (
    id integer DEFAULT nextval('form_c_new_demand_id_seq'::regclass) NOT NULL,
    campaign_type character varying(30),
    uncode character varying(9),
    distcode character varying(3),
    procode character varying(1),
    start_date date,
    end_date date,
    doses_per_vial double precision DEFAULT 0,
    report_submitted integer DEFAULT 0,
    target double precision DEFAULT 0,
    wastage_facter double precision DEFAULT 0,
    required_doses double precision DEFAULT 0,
    required_vials double precision DEFAULT 0,
    opening_bal_vials double precision DEFAULT 0,
    requested_vials double precision DEFAULT 0,
    recieved_vials double precision DEFAULT 0,
    child_vacc_dose double precision DEFAULT 0,
    vials_used double precision DEFAULT 0,
    vials_unused double precision DEFAULT 0,
    closing_bal double precision DEFAULT 0,
    group_id integer,
    requested_by_name character varying(50),
    requested_by_desg character varying(30),
    requested_by_store character varying(30),
    requested_on date,
    received_by_name character varying(50),
    received_by_desg character varying(30),
    received_by_store character varying(30),
    received_on date,
    reported_by_name character varying(50),
    reported_by_desg character varying(30),
    reported_by_store character varying(30),
    reported_on date,
    othername character varying(100),
    from_fmonth character varying(7),
    to_fmonth character varying(7),
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    vaccine_type integer
);


ALTER TABLE public.form_c_new_demand OWNER TO postgres;

--
-- Name: funding_source_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE funding_source_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999
    CACHE 1;


ALTER TABLE public.funding_source_seq OWNER TO postgres;

--
-- Name: geo_levels_pkid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE geo_levels_pkid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2739999999
    CACHE 1;


ALTER TABLE public.geo_levels_pkid_seq OWNER TO postgres;

--
-- Name: geo_levels; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE geo_levels (
    pk_id integer DEFAULT nextval('geo_levels_pkid_seq'::regclass) NOT NULL,
    geo_level_name character varying(255) DEFAULT NULL::character varying,
    description text,
    created_by integer DEFAULT 1 NOT NULL,
    created_date date,
    modified_by integer DEFAULT 1 NOT NULL,
    modified_date timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.geo_levels OWNER TO postgres;

--
-- Name: go_db; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE go_db (
    go_code character varying(5) NOT NULL,
    go_name character varying(40),
    fathername character varying(40),
    nic character varying(20),
    date_of_birth date,
    procode character varying(1) DEFAULT '2'::character varying NOT NULL,
    distcode character varying(3) NOT NULL,
    tcode character varying(8),
    facode character varying(6),
    uncode character varying(12),
    permanent_address character varying(120),
    present_address character varying(120),
    postalcode character varying(15),
    city character varying(40),
    phone character varying(20),
    area_type character varying(20),
    status character varying(15),
    marital_status character varying(15),
    lastqualification character varying(15),
    passingyear integer,
    institutename character varying(120),
    date_joining date,
    place_of_joining character varying(80),
    place_of_posting character varying(80),
    designation character varying(80),
    bankaccountno character varying(30),
    payscale character varying(10),
    bid character varying(6),
    basicpay double precision,
    husbandname character varying(50),
    date_termination date,
    date_transfer date,
    date_died date,
    date_retired date,
    c_id integer DEFAULT nextval('codb_seq'::regclass) NOT NULL,
    branchcode character varying(15),
    branchname character varying(50),
    employee_type character varying(15),
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    basic_training_start_date date,
    basic_training_end_date date,
    routine_epi_start_date date,
    routine_epi_end_date date,
    survilance_training_start_date date,
    survilance_training_end_date date,
    cold_chain_training_start_date date,
    cold_chain_training_end_date date,
    vlmis_training_start_date date,
    vlmis_training_end_date date,
    date_resigned date,
    reason text,
    previous_table text,
    previous_code integer,
    date_from date,
    date_to date
);


ALTER TABLE public.go_db OWNER TO postgres;

--
-- Name: group_filter_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE group_filter_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.group_filter_id_seq OWNER TO postgres;

--
-- Name: group_filters_info; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE group_filters_info (
    pk_id integer DEFAULT nextval('group_filter_id_seq'::regclass) NOT NULL,
    filters_concate_id integer NOT NULL,
    sub_indicator_id integer NOT NULL,
    select_columns text NOT NULL,
    result_format character varying(30),
    multiplier integer,
    formula_string text,
    denominator_formula integer
);


ALTER TABLE public.group_filters_info OWNER TO postgres;

--
-- Name: TABLE group_filters_info; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE group_filters_info IS 'grouped filter information will be stored in this table';


--
-- Name: hf_quarterplan_dates_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE hf_quarterplan_dates_seq
    START WITH 16812
    INCREMENT BY 1
    MINVALUE 16812
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.hf_quarterplan_dates_seq OWNER TO postgres;

--
-- Name: hf_quarterplan_dates_db; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE hf_quarterplan_dates_db (
    ms_id integer NOT NULL,
    link_id integer NOT NULL,
    pk_id integer DEFAULT nextval('hf_quarterplan_dates_seq'::regclass) NOT NULL,
    procode character varying(1) NOT NULL,
    distcode character varying(3) NOT NULL,
    tcode character varying(6) DEFAULT 0 NOT NULL,
    uncode character varying(9) DEFAULT 0 NOT NULL,
    facode character varying(6) DEFAULT 0 NOT NULL,
    quarter integer DEFAULT 0 NOT NULL,
    year integer DEFAULT 0 NOT NULL,
    techniciancode character varying(9) NOT NULL,
    area_dateschedule_m1 date,
    area_dateschedule_m2 date,
    area_dateschedule_m3 date,
    area_dateheld_m1 date,
    area_dateheld_m2 date,
    area_dateheld_m3 date,
    sitename_s text,
    sitename_h text,
    session_type character varying(25),
    area_code character varying(12)
);


ALTER TABLE public.hf_quarterplan_dates_db OWNER TO postgres;

--
-- Name: hf_quarterplan_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE hf_quarterplan_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.hf_quarterplan_seq OWNER TO postgres;

--
-- Name: hf_quarterplan_dates_dbold; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE hf_quarterplan_dates_dbold (
    area_dateschedule_m1 date,
    area_dateschedule_m2 date,
    area_dateschedule_m3 date,
    area_dateheld_m1 date,
    area_dateheld_m2 date,
    area_dateheld_m3 date,
    id integer DEFAULT nextval('hf_quarterplan_seq'::regclass) NOT NULL,
    ms_id integer,
    link_id integer,
    sitename_s character varying,
    sitename_h character varying
);


ALTER TABLE public.hf_quarterplan_dates_dbold OWNER TO postgres;

--
-- Name: hf_quarterplan_db; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE hf_quarterplan_db (
    pk_id integer DEFAULT nextval('hf_quarterplan_seq'::regclass) NOT NULL,
    procode character varying(1) NOT NULL,
    distcode character varying(3) NOT NULL,
    tcode character varying(6) DEFAULT 0 NOT NULL,
    uncode character varying(9) DEFAULT 0 NOT NULL,
    facode character varying(6) DEFAULT 0 NOT NULL,
    quarter integer,
    year integer,
    techniciancode character varying(9) NOT NULL,
    ahtr_activities_m1 text,
    ahtr_activities_m2 text,
    ahtr_activities_m3 text,
    ahtr_resperson_m1 text,
    ahtr_resperson_m2 text,
    ahtr_resperson_m3 text,
    ra_activities_m1 text,
    ra_activities_m2 text,
    ra_activities_m3 text,
    ra_resperson_m1 text,
    ra_resperson_m2 text,
    ra_resperson_m3 text,
    sh_fixed_m1 integer,
    sh_fixed_m2 integer,
    sh_fixed_m3 integer,
    sh_outreach_m1 integer,
    sh_outreach_m2 integer,
    sh_outreach_m3 integer,
    sh_mobile_m1 integer,
    sh_mobile_m2 integer,
    sh_mobile_m3 integer,
    sp_fixed_m1 integer,
    sp_fixed_m2 integer,
    sp_fixed_m3 integer,
    sp_outreach_m1 integer,
    sp_outreach_m2 integer,
    sp_outreach_m3 integer,
    sp_mobile_m1 integer,
    sp_mobile_m2 integer,
    sp_mobile_m3 integer,
    submitted_date date,
    updated_date date
);


ALTER TABLE public.hf_quarterplan_db OWNER TO postgres;

--
-- Name: hf_quarterplan_dbold; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE hf_quarterplan_dbold (
    recid integer DEFAULT nextval('hf_quarterplan_seq'::regclass) NOT NULL,
    procode character varying(1) DEFAULT 3,
    distcode character varying(3) NOT NULL,
    tcode character varying(6) NOT NULL,
    uncode character varying(9),
    facode character varying(6) NOT NULL,
    year character varying(4) NOT NULL,
    quarter integer DEFAULT 0 NOT NULL,
    month character varying(2),
    area1_name character varying(255),
    area1_num_sessions integer DEFAULT 0,
    area1_dateschedule_m1 date,
    area1_dateheld_m1 date,
    area1_transport_m1 character varying(100),
    area1_resperson_m1 character varying(100),
    area1_distsupport_m1 character varying(3),
    area1_dateschedule_m2 date,
    area1_dateheld_m2 date,
    area1_transport_m2 character varying(100),
    area1_resperson_m2 character varying(100),
    area1_distsupport_m2 character varying(3),
    area1_dateschedule_m3 date,
    area1_dateheld_m3 date,
    area1_transport_m3 character varying(100),
    area1_resperson_m3 character varying(100),
    area1_distsupport_m3 character varying(3),
    area2_name character varying(255),
    area2_num_sessions integer DEFAULT 0,
    area2_dateschedule_m1 date,
    area2_dateheld_m1 date,
    area2_transport_m1 character varying(100),
    area2_resperson_m1 character varying(100),
    area2_distsupport_m1 character varying(3),
    area2_dateschedule_m2 date,
    area2_dateheld_m2 date,
    area2_transport_m2 character varying(100),
    area2_resperson_m2 character varying(100),
    area2_distsupport_m2 character varying(3),
    area2_dateschedule_m3 date,
    area2_dateheld_m3 date,
    area2_transport_m3 character varying(100),
    area2_resperson_m3 character varying(100),
    area2_distsupport_m3 character varying(3),
    area3_name character varying(255),
    area3_num_sessions integer DEFAULT 0,
    area3_dateschedule_m1 date,
    area3_dateheld_m1 date,
    area3_transport_m1 character varying(100),
    area3_resperson_m1 character varying(100),
    area3_distsupport_m1 character varying(3),
    area3_dateschedule_m2 date,
    area3_dateheld_m2 date,
    area3_transport_m2 character varying(100),
    area3_resperson_m2 character varying(100),
    area3_distsupport_m2 character varying(3),
    area3_dateschedule_m3 date,
    area3_dateheld_m3 date,
    area3_transport_m3 character varying(100),
    area3_resperson_m3 character varying(100),
    area3_distsupport_m3 character varying(3),
    ahtr_activities_m1 text,
    ahtr_resperson_m1 character varying(100),
    ahtr_activities_m2 text,
    ahtr_resperson_m2 character varying(100),
    ahtr_activities_m3 text,
    ahtr_resperson_m3 character varying(100),
    ra_activities_m1 text,
    ra_resperson_m1 character varying(100),
    ra_activities_m2 text,
    ra_resperson_m2 character varying(100),
    ra_activities_m3 text,
    ra_resperson_m3 character varying(100),
    msi_numheld_m1 integer DEFAULT 0,
    msi_numplan_m1 integer DEFAULT 0,
    msi_numheld_m2 integer DEFAULT 0,
    msi_numplan_m2 integer DEFAULT 0,
    msi_numheld_m3 integer DEFAULT 0,
    msi_numplan_m3 integer DEFAULT 0,
    q1 integer DEFAULT 0,
    q2 integer DEFAULT 0,
    q3 integer DEFAULT 0,
    q4 integer DEFAULT 0,
    submitted_date date NOT NULL,
    updated_date date,
    sh_fixed_m1 integer,
    sh_fixed_m2 integer,
    sh_fixed_m3 integer,
    sh_outreach_m1 integer,
    sh_outreach_m2 integer,
    sh_outreach_m3 integer,
    sh_mobile_m1 integer,
    sh_mobile_m2 integer,
    sh_mobile_m3 integer,
    sp_fixed_m1 integer,
    sp_fixed_m2 integer,
    sp_fixed_m3 integer,
    sp_outreach_m1 integer,
    sp_outreach_m2 integer,
    sp_outreach_m3 integer,
    sp_mobile_m1 integer,
    sp_mobile_m2 integer,
    sp_mobile_m3 integer
);


ALTER TABLE public.hf_quarterplan_dbold OWNER TO postgres;

--
-- Name: hf_quarterplan_nm_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE hf_quarterplan_nm_seq
    START WITH 16811
    INCREMENT BY 1
    MINVALUE 16811
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.hf_quarterplan_nm_seq OWNER TO postgres;

--
-- Name: hf_quarterplan_nm_db; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE hf_quarterplan_nm_db (
    ms_id integer NOT NULL,
    pk_id integer DEFAULT nextval('hf_quarterplan_nm_seq'::regclass) NOT NULL,
    area_code character varying(12) NOT NULL,
    area_num_sessions integer,
    area_transport_m1 character varying(100),
    area_resperson_m1 character varying(100),
    area_distsupport_m1 character varying(3) DEFAULT 0,
    area_transport_m2 character varying(100),
    area_resperson_m2 character varying(100),
    area_distsupport_m2 character varying(3) DEFAULT 0,
    area_transport_m3 character varying(100),
    area_resperson_m3 character varying(100),
    area_distsupport_m3 character varying(3) DEFAULT 0,
    procode character varying(1),
    distcode character varying(3),
    tcode character varying(6),
    uncode character varying(9),
    facode character varying(6),
    quarter integer,
    year integer,
    techniciancode character varying(9),
    session_type character varying(25)
);


ALTER TABLE public.hf_quarterplan_nm_db OWNER TO postgres;

--
-- Name: hf_quarterplan_nm_db_dis_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE hf_quarterplan_nm_db_dis_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.hf_quarterplan_nm_db_dis_seq OWNER TO postgres;

--
-- Name: hf_quarterplan_nm_db_dis_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE hf_quarterplan_nm_db_dis_seq OWNED BY hf_quarterplan_nm_db.distcode;


--
-- Name: hf_quarterplan_nm_dbold; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE hf_quarterplan_nm_dbold (
    area_name character varying(255),
    area_num_sessions integer,
    area_transport_m1 character varying(100),
    area_resperson_m1 character varying(100),
    area_distsupport_m1 character varying(3),
    area_transport_m2 character varying(100),
    area_resperson_m2 character varying(100),
    area_distsupport_m2 character varying(3),
    area_transport_m3 character varying(100),
    area_resperson_m3 character varying(100),
    area_distsupport_m3 character varying(3),
    ms_id integer,
    pk_id integer DEFAULT nextval('hf_quarterplan_seq'::regclass) NOT NULL,
    session_type character varying
);


ALTER TABLE public.hf_quarterplan_nm_dbold OWNER TO postgres;

--
-- Name: hrappusers_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE hrappusers_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999999
    CACHE 1;


ALTER TABLE public.hrappusers_seq OWNER TO postgres;

--
-- Name: hr_app_users; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE hr_app_users (
    pk_id integer DEFAULT nextval('hrappusers_seq'::regclass) NOT NULL,
    fk_hr_code character varying(9) NOT NULL,
    pin_no character varying(32) NOT NULL,
    imei_no character varying(15),
    model_no text,
    app_type character varying(20) NOT NULL,
    active integer DEFAULT 0,
    device_name character varying(30),
    android_version character varying(15),
    created_date date DEFAULT now(),
    pn_token text,
    login_token character varying(32)
);


ALTER TABLE public.hr_app_users OWNER TO postgres;

--
-- Name: COLUMN hr_app_users.pn_token; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_app_users.pn_token IS 'Push Notification Token will be saved in this column for sending push notification';


--
-- Name: hr_db_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE hr_db_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999
    CACHE 1;


ALTER TABLE public.hr_db_id_seq OWNER TO postgres;

--
-- Name: hr_db; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE hr_db (
    id integer DEFAULT nextval('hr_db_id_seq'::regclass) NOT NULL,
    code character varying(9) NOT NULL,
    hr_type_id integer NOT NULL,
    hr_sub_type_id character varying(2) NOT NULL,
    level character varying(2) NOT NULL,
    name text NOT NULL,
    fathername text,
    guardian_name text,
    nic character varying(15) NOT NULL,
    date_of_birth date,
    procode character varying(1) NOT NULL,
    distcode character varying(3),
    tcode character varying(8),
    uncode character varying(12),
    facode character varying(6),
    catch_area_name character varying(60),
    permanent_address character varying(120),
    present_address character varying(120),
    lastqualification text,
    passingyear character varying,
    institutename text,
    date_joining date,
    place_of_joining text,
    status_reason text,
    areatype character varying(15),
    phone character varying(15),
    emergency_no character varying(15),
    marital_status character varying(10),
    bankaccountno character varying(25),
    payscale character varying(10),
    bid character varying(6),
    basicpay double precision,
    allowances double precision,
    deductions double precision,
    branchcode character varying(15),
    branchname text,
    employee_type character varying(50) NOT NULL,
    previous_code character varying(9),
    iemi_no text,
    pin_no integer,
    created_date timestamp without time zone NOT NULL,
    created_by character varying(50) NOT NULL,
    updated_date timestamp without time zone,
    updated_by character varying(50),
    gender character varying(1),
    is_deleted integer DEFAULT 0
);


ALTER TABLE public.hr_db OWNER TO postgres;

--
-- Name: COLUMN hr_db.code; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_db.code IS 'first 2 digits year, next 2 month, next five unique, it will be used for fk in other tables';


--
-- Name: COLUMN hr_db.hr_type_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_db.hr_type_id IS 'fk from hr_types,to identify user designation cat like sup,technician etc';


--
-- Name: COLUMN hr_db.hr_sub_type_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_db.hr_sub_type_id IS 'foreign key from hr_sub_types table to identify user actual designation';


--
-- Name: COLUMN hr_db.level; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_db.level IS 'foreign key from hr_levels table, to identify user level';


--
-- Name: COLUMN hr_db.lastqualification; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_db.lastqualification IS 'highest qualification, fk from hr_qualifications table in string form';


--
-- Name: COLUMN hr_db.status_reason; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_db.status_reason IS 'if any specific reson of current status like transfer reason etc';


--
-- Name: COLUMN hr_db.areatype; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_db.areatype IS 'rural,urban,semi-urban etc';


--
-- Name: COLUMN hr_db.bid; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_db.bid IS 'foreign key from bankinfo db, to identify bank details';


--
-- Name: COLUMN hr_db.branchcode; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_db.branchcode IS 'can be linked with bankdb branchcode column, yet not linked';


--
-- Name: COLUMN hr_db.employee_type; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_db.employee_type IS 'for example, contract, regular, contingent etc';


--
-- Name: COLUMN hr_db.previous_code; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_db.previous_code IS 'can be duplicate, can be NULL, used when status changed mostly';


--
-- Name: COLUMN hr_db.created_by; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_db.created_by IS 'user name from users table';


--
-- Name: COLUMN hr_db.updated_by; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_db.updated_by IS 'user name from users tables';


--
-- Name: hr_db_history_id_new_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE hr_db_history_id_new_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999
    CACHE 1;


ALTER TABLE public.hr_db_history_id_new_seq OWNER TO postgres;

--
-- Name: hr_db_history; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE hr_db_history (
    id integer DEFAULT nextval('hr_db_history_id_new_seq'::regclass) NOT NULL,
    code character varying(9) NOT NULL,
    pre_hr_type_id integer NOT NULL,
    post_hr_type_id integer,
    pre_hr_sub_type_id character varying(2) NOT NULL,
    post_hr_sub_type_id character varying(2),
    pre_level character varying(2) NOT NULL,
    name text NOT NULL,
    fathername text,
    guardian_name text,
    nic character varying(15) NOT NULL,
    date_of_birth date,
    pre_procode character varying(1) NOT NULL,
    post_procode character varying(1),
    pre_distcode character varying(3),
    post_distcode character varying(3),
    pre_tcode character varying(8),
    post_tcode character varying(8),
    pre_uncode character varying(12),
    post_uncode character varying(12),
    pre_facode character varying(6),
    post_facode character varying(6),
    catch_area_name character varying(60),
    permanent_address character varying(120),
    present_address character varying(120),
    lastqualification text,
    passingyear character varying,
    institutename text,
    date_joining date,
    place_of_joining text,
    pre_status character varying(25) NOT NULL,
    post_status character varying(25),
    status_date date,
    status_reason text,
    areatype character varying(15),
    phone character varying(15),
    emergency_no character varying(15),
    marital_status character varying(10),
    bankaccountno character varying(25),
    payscale character varying(10),
    bid character varying(6),
    basicpay double precision,
    allowances double precision,
    deductions double precision,
    branchcode character varying(15),
    branchname text,
    employee_type character varying(50) NOT NULL,
    previous_code character varying(9),
    iemi_no text,
    pin_no integer,
    created_date timestamp without time zone NOT NULL,
    created_by character varying(50) NOT NULL,
    updated_date timestamp without time zone,
    updated_by character varying(50),
    post_level character varying(2),
    gender character varying(1),
    newid integer,
    is_deleted integer DEFAULT 0
);


ALTER TABLE public.hr_db_history OWNER TO postgres;

--
-- Name: hr_db_history_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE hr_db_history_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999
    CACHE 1;


ALTER TABLE public.hr_db_history_id_seq OWNER TO postgres;

--
-- Name: hr_db_history_backup 1/6/2020; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "hr_db_history_backup 1/6/2020" (
    id integer DEFAULT nextval('hr_db_history_id_seq'::regclass) NOT NULL,
    code character varying(9) NOT NULL,
    pre_hr_type_id integer NOT NULL,
    post_hr_type_id integer,
    pre_hr_sub_type_id character varying(2) NOT NULL,
    post_hr_sub_type_id character varying(2),
    pre_level character varying(2) NOT NULL,
    name text NOT NULL,
    fathername text,
    guardian_name text,
    nic character varying(15) NOT NULL,
    date_of_birth date,
    pre_procode character varying(1) NOT NULL,
    post_procode character varying(1),
    pre_distcode character varying(3),
    post_distcode character varying(3),
    pre_tcode character varying(8),
    post_tcode character varying(8),
    pre_uncode character varying(12),
    post_uncode character varying(12),
    pre_facode character varying(6),
    post_facode character varying(6),
    catch_area_name character varying(60),
    permanent_address character varying(120),
    present_address character varying(120),
    lastqualification text,
    passingyear character varying,
    institutename text,
    date_joining date,
    place_of_joining text,
    pre_status character varying(25) NOT NULL,
    post_status character varying(25),
    status_date date,
    status_reason text,
    areatype character varying(15),
    phone character varying(15),
    emergency_no character varying(15),
    marital_status character varying(10),
    bankaccountno character varying(25),
    payscale character varying(10),
    bid character varying(6),
    basicpay double precision,
    allowances double precision,
    deductions double precision,
    branchcode character varying(15),
    branchname text,
    employee_type character varying(50) NOT NULL,
    previous_code character varying(9),
    iemi_no text,
    pin_no integer,
    created_date timestamp without time zone NOT NULL,
    created_by character varying(50) NOT NULL,
    updated_date timestamp without time zone,
    updated_by character varying(50),
    post_level character varying(2),
    gender character varying(1)
);


ALTER TABLE public."hr_db_history_backup 1/6/2020" OWNER TO postgres;

--
-- Name: hr_db_id_new_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE hr_db_id_new_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999
    CACHE 1;


ALTER TABLE public.hr_db_id_new_seq OWNER TO postgres;

--
-- Name: hr_db_new; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE hr_db_new (
    id integer DEFAULT nextval('hr_db_id_new_seq'::regclass) NOT NULL,
    code character varying(9) NOT NULL,
    hr_type_id integer NOT NULL,
    hr_sub_type_id character varying(2) NOT NULL,
    level character varying(2) NOT NULL,
    name text NOT NULL,
    fathername text,
    guardian_name text,
    nic character varying(15) NOT NULL,
    date_of_birth date,
    procode character varying(1) NOT NULL,
    distcode character varying(3),
    tcode character varying(8),
    uncode character varying(12),
    facode character varying(6),
    catch_area_name character varying(60),
    permanent_address character varying(120),
    present_address character varying(120),
    lastqualification text,
    passingyear character varying,
    institutename text,
    date_joining date,
    place_of_joining text,
    status_reason text,
    areatype character varying(15),
    phone character varying(15),
    emergency_no character varying(15),
    marital_status character varying(10),
    bankaccountno character varying(25),
    payscale character varying(10),
    bid character varying(6),
    basicpay double precision,
    allowances double precision,
    deductions double precision,
    branchcode character varying(15),
    branchname text,
    employee_type character varying(50) NOT NULL,
    previous_code character varying(9),
    iemi_no text,
    pin_no integer,
    created_date timestamp without time zone NOT NULL,
    created_by character varying(50) NOT NULL,
    updated_date timestamp without time zone,
    updated_by character varying(50),
    gender character varying(1)
);


ALTER TABLE public.hr_db_new OWNER TO postgres;

--
-- Name: hr_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE hr_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.hr_id_seq OWNER TO postgres;

--
-- Name: hr_leave_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE hr_leave_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999
    CACHE 1;


ALTER TABLE public.hr_leave_id_seq OWNER TO postgres;

--
-- Name: hr_leave; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE hr_leave (
    id integer DEFAULT nextval('hr_leave_id_seq'::regclass) NOT NULL,
    hr_code character varying(9) NOT NULL,
    leave_start_date date,
    leave_end_date date,
    reason text,
    remarks character varying(50),
    approved_by character varying(40),
    created_date timestamp without time zone,
    created_by character varying(50)
);


ALTER TABLE public.hr_leave OWNER TO postgres;

--
-- Name: hr_leave_history_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE hr_leave_history_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999
    CACHE 1;


ALTER TABLE public.hr_leave_history_id_seq OWNER TO postgres;

--
-- Name: hr_levels_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE hr_levels_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.hr_levels_id_seq OWNER TO postgres;

--
-- Name: hr_levels; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE hr_levels (
    id integer DEFAULT nextval('hr_levels_id_seq'::regclass) NOT NULL,
    name text NOT NULL,
    code character varying(2) NOT NULL,
    is_active character varying(1) DEFAULT 0 NOT NULL,
    created_date timestamp without time zone,
    created_by character varying(50)
);


ALTER TABLE public.hr_levels OWNER TO postgres;

--
-- Name: COLUMN hr_levels.name; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_levels.name IS 'Federal,Provincial….. Facility';


--
-- Name: COLUMN hr_levels.code; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_levels.code IS '1,2,3…..7';


--
-- Name: COLUMN hr_levels.is_active; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_levels.is_active IS 'if this level is active for region or not.';


--
-- Name: COLUMN hr_levels.created_by; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_levels.created_by IS 'user id';


--
-- Name: hr_qualifications_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE hr_qualifications_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.hr_qualifications_id_seq OWNER TO postgres;

--
-- Name: hr_status; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE hr_status (
    post_status character varying(25)
);


ALTER TABLE public.hr_status OWNER TO postgres;

--
-- Name: hr_sub_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE hr_sub_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.hr_sub_types_id_seq OWNER TO postgres;

--
-- Name: hr_sub_types; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE hr_sub_types (
    id integer DEFAULT nextval('hr_sub_types_id_seq'::regclass) NOT NULL,
    type_id character varying(2) NOT NULL,
    title text NOT NULL,
    description text,
    hr_type_id integer NOT NULL,
    supportive_supervision integer,
    is_active character varying(1) DEFAULT 0 NOT NULL,
    created_date timestamp without time zone,
    created_by character varying(50)
);


ALTER TABLE public.hr_sub_types OWNER TO postgres;

--
-- Name: COLUMN hr_sub_types.type_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_sub_types.type_id IS 'will be used as foreign key for other tables';


--
-- Name: COLUMN hr_sub_types.hr_type_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_sub_types.hr_type_id IS 'foreign key of hr_types table';


--
-- Name: COLUMN hr_sub_types.supportive_supervision; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_sub_types.supportive_supervision IS '1/0';


--
-- Name: COLUMN hr_sub_types.created_by; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_sub_types.created_by IS 'user id';


--
-- Name: hr_training_history_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE hr_training_history_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999
    CACHE 1;


ALTER TABLE public.hr_training_history_id_seq OWNER TO postgres;

--
-- Name: hr_training_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE hr_training_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.hr_training_id_seq OWNER TO postgres;

--
-- Name: hr_trainings; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE hr_trainings (
    id integer DEFAULT nextval('hr_training_id_seq'::regclass) NOT NULL,
    hr_code character varying(9),
    training_id integer,
    created_date timestamp without time zone,
    created_by character varying(50)
);


ALTER TABLE public.hr_trainings OWNER TO postgres;

--
-- Name: COLUMN hr_trainings.hr_code; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_trainings.hr_code IS 'foreign key from hr_db code column';


--
-- Name: COLUMN hr_trainings.training_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_trainings.training_id IS 'foreign key from training_types table';


--
-- Name: COLUMN hr_trainings.created_by; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_trainings.created_by IS 'user id';


--
-- Name: hr_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE hr_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.hr_types_id_seq OWNER TO postgres;

--
-- Name: hr_types; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE hr_types (
    id integer DEFAULT nextval('hr_types_id_seq'::regclass) NOT NULL,
    name text NOT NULL,
    is_active character varying(1) DEFAULT 0 NOT NULL,
    created_date timestamp without time zone,
    created_by character varying(50)
);


ALTER TABLE public.hr_types OWNER TO postgres;

--
-- Name: COLUMN hr_types.name; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_types.name IS 'Supervisor, Technician';


--
-- Name: COLUMN hr_types.is_active; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_types.is_active IS 'if type is applicable for logged in region/user or not.';


--
-- Name: COLUMN hr_types.created_by; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN hr_types.created_by IS 'user id';


--
-- Name: hrdb; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE hrdb (
    nic character varying(15),
    date_of_birth date,
    procode character varying(1) NOT NULL,
    uncode character varying(12),
    catch_area_pop integer,
    catch_area_name character varying(60),
    permanent_address character varying(120),
    present_address character varying(120),
    lastqualification character varying(15),
    passingyear integer,
    institutename character varying(120),
    date_joining date,
    place_of_joining character varying(200),
    date_termination date,
    status character varying(30),
    areatype character varying(6),
    basic_training_start_date date,
    basic_training_end_date date,
    routine_epi_start_date date,
    routine_epi_end_date date,
    id integer DEFAULT nextval('hr_id_seq'::regclass) NOT NULL,
    city character varying(50),
    phone character varying(30),
    marital_status character varying(40),
    designation character varying(50),
    bankaccountno character varying(40),
    payscale character varying(30),
    bid character varying(10),
    basicpay double precision,
    date_transfer date,
    date_died date,
    date_retired date,
    survilance_training_start_date date,
    survilance_training_end_date date,
    cold_chain_training_start_date date,
    cold_chain_training_end_date date,
    vlmis_training_start_date date,
    vlmis_training_end_date date,
    rec_training_start_date date,
    rec_training_end_date date,
    branchcode character varying(15),
    branchname character varying(50),
    employee_type character varying(50),
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    current_status text,
    previous_code character varying(9),
    designation_type character varying(60),
    hrcode character varying(10) NOT NULL,
    telephone character varying(15),
    date_resigned date,
    type character varying(40),
    hrname character varying(40),
    distcode character varying(3)
);


ALTER TABLE public.hrdb OWNER TO postgres;

--
-- Name: ids_cases_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE ids_cases_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.ids_cases_seq OWNER TO postgres;

--
-- Name: ids_disease_cases; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE ids_disease_cases (
    case_type character varying(100),
    case_name character varying(100),
    case_father_name character varying(100),
    case_address character varying(100),
    case_age character varying(100),
    case_sex character varying(100),
    case_date_onset date,
    case_tot_vacc_received integer DEFAULT 0,
    case_last_dose_received date,
    case_presentation character varying(100),
    facode character varying(6),
    distcode character varying(3),
    fweek character varying(10),
    vpd_id integer NOT NULL,
    id integer DEFAULT nextval('ids_cases_seq'::regclass) NOT NULL,
    procode character varying(1) DEFAULT 3
);


ALTER TABLE public.ids_disease_cases OWNER TO postgres;

--
-- Name: ids_disease_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE ids_disease_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.ids_disease_seq OWNER TO postgres;

--
-- Name: ids_diseases; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE ids_diseases (
    id integer DEFAULT nextval('ids_disease_seq'::regclass) NOT NULL,
    disease_name character varying(1000),
    disease_short_name character varying(100),
    sec_id integer,
    disease_abbr character varying(100)
);


ALTER TABLE public.ids_diseases OWNER TO postgres;

--
-- Name: ids_sec_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE ids_sec_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.ids_sec_seq OWNER TO postgres;

--
-- Name: ids_diseases_sec; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE ids_diseases_sec (
    id integer DEFAULT nextval('ids_sec_seq'::regclass) NOT NULL,
    respiratory_diseases character varying(100)
);


ALTER TABLE public.ids_diseases_sec OWNER TO postgres;

--
-- Name: ids_report_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE ids_report_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.ids_report_seq OWNER TO postgres;

--
-- Name: ids_report_form; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE ids_report_form (
    id integer DEFAULT nextval('ids_report_seq'::regclass) NOT NULL,
    distcode character varying(3),
    tcode character varying(6),
    uncode character varying(9),
    facode character varying(6),
    flcf_pop character varying(50) DEFAULT 0,
    reported_by character varying(100),
    contact_no character varying(16),
    affected_pop character varying(50) DEFAULT 0,
    urti_cases double precision DEFAULT 0,
    urti_deaths double precision DEFAULT 0,
    pneu_less_five_cases double precision DEFAULT 0,
    pneu_less_five_deaths double precision DEFAULT 0,
    pneu_great_five_cases double precision DEFAULT 0,
    pneu_great_five_deaths double precision DEFAULT 0,
    sari_cases double precision DEFAULT 0,
    sari_deaths double precision DEFAULT 0,
    awd_less_five_cases double precision DEFAULT 0,
    awd_less_five_deaths double precision DEFAULT 0,
    awd_great_five_cases double precision DEFAULT 0,
    awd_great_five_deaths double precision DEFAULT 0,
    bd_cases double precision DEFAULT 0,
    bd_deaths double precision DEFAULT 0,
    ad_cases double precision DEFAULT 0,
    ad_deaths double precision DEFAULT 0,
    tf_cases double precision DEFAULT 0,
    tf_deaths double precision DEFAULT 0,
    avh_cases double precision DEFAULT 0,
    avh_deaths double precision DEFAULT 0,
    mal_cases double precision DEFAULT 0,
    mal_deaths double precision DEFAULT 0,
    df_cases double precision DEFAULT 0,
    df_deaths double precision DEFAULT 0,
    dhf_cases double precision DEFAULT 0,
    dhf_deaths double precision DEFAULT 0,
    cchf_cases double precision DEFAULT 0,
    cchf_deaths double precision DEFAULT 0,
    cl_cases double precision DEFAULT 0,
    cl_deaths double precision DEFAULT 0,
    vl_cases double precision DEFAULT 0,
    vl_deaths double precision DEFAULT 0,
    msl_cases double precision DEFAULT 0,
    msl_deaths double precision DEFAULT 0,
    diph_cases double precision DEFAULT 0,
    diph_deaths double precision DEFAULT 0,
    pert_cases double precision DEFAULT 0,
    pert_deaths double precision DEFAULT 0,
    nnt_cases double precision DEFAULT 0,
    nnt_deaths double precision DEFAULT 0,
    afp_cases double precision DEFAULT 0,
    afp_deaths double precision DEFAULT 0,
    chtb_cases double precision DEFAULT 0,
    chtb_deaths double precision DEFAULT 0,
    meng_cases double precision DEFAULT 0,
    meng_deaths double precision DEFAULT 0,
    puo_cases double precision DEFAULT 0,
    puo_deaths double precision DEFAULT 0,
    psy_cases double precision DEFAULT 0,
    psy_deaths double precision DEFAULT 0,
    undis_cases double precision DEFAULT 0,
    undis_deaths double precision DEFAULT 0,
    tm_less_one double precision DEFAULT 0,
    tm_oneto_four double precision DEFAULT 0,
    tm_five_fourteen double precision DEFAULT 0,
    tm_fifteen_fourtynine double precision DEFAULT 0,
    tm_fifty_plus double precision DEFAULT 0,
    tf_less_one double precision DEFAULT 0,
    tf_oneto_four double precision DEFAULT 0,
    tf_five_fourteen double precision DEFAULT 0,
    tf_fifteen_fourtynine double precision DEFAULT 0,
    tf_fifty_plus double precision DEFAULT 0,
    tot_opd_attendance double precision DEFAULT 0,
    date_from date,
    date_to date,
    year character varying(4),
    fweek character varying(7),
    epi_week integer NOT NULL,
    procode character varying(1),
    other integer,
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL
);


ALTER TABLE public.ids_report_form OWNER TO postgres;

--
-- Name: COLUMN ids_report_form.is_temp_saved; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN ids_report_form.is_temp_saved IS '0 means form is completely filled and saved from submit button, 1 means checklist is not completed and temporarily saved for re-edit later';


--
-- Name: idsrs_diseases_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE idsrs_diseases_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1
    CYCLE;


ALTER TABLE public.idsrs_diseases_seq OWNER TO postgres;

--
-- Name: idsrs_cases_types; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE idsrs_cases_types (
    id integer DEFAULT nextval('idsrs_diseases_seq'::regclass) NOT NULL,
    type_case_name text NOT NULL,
    type_short_code text NOT NULL,
    cases text NOT NULL,
    deaths text NOT NULL,
    pro integer DEFAULT 0
);


ALTER TABLE public.idsrs_cases_types OWNER TO postgres;

--
-- Name: idsrs_wvpd_recid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE idsrs_wvpd_recid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1
    CYCLE;


ALTER TABLE public.idsrs_wvpd_recid_seq OWNER TO postgres;

--
-- Name: ind_col_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE ind_col_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999999
    CACHE 1;


ALTER TABLE public.ind_col_seq OWNER TO postgres;

--
-- Name: ind_main_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE ind_main_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999999999999999
    CACHE 1;


ALTER TABLE public.ind_main_seq OWNER TO postgres;

--
-- Name: indcat_indid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE indcat_indid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.indcat_indid_seq OWNER TO postgres;

--
-- Name: indcat; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE indcat (
    indid integer DEFAULT nextval('indcat_indid_seq'::regclass) NOT NULL,
    ind_name character varying(150),
    formula character varying(600),
    multiple integer DEFAULT 0,
    ind_type character varying(50),
    numerator text,
    denominator text,
    is_inverse integer,
    result_text text,
    description text,
    rel_report text
);


ALTER TABLE public.indcat OWNER TO postgres;

--
-- Name: COLUMN indcat.rel_report; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN indcat.rel_report IS 'write report short name for making of different indicator report for different modules. We can filter our indicators based on this column.';


--
-- Name: indicator_column; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE indicator_column (
    indcol integer DEFAULT nextval('ind_col_seq'::regclass) NOT NULL,
    indmain integer,
    formula_column text,
    table_name character varying(50),
    column_name character varying(100)
);


ALTER TABLE public.indicator_column OWNER TO postgres;

--
-- Name: indicator_filters; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE indicator_filters (
    "pk_id " integer NOT NULL,
    indicator_id integer NOT NULL,
    filter_id integer NOT NULL,
    sub_indicator_id integer NOT NULL
);


ALTER TABLE public.indicator_filters OWNER TO postgres;

--
-- Name: TABLE indicator_filters; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE indicator_filters IS 'Gerund table for indicators and their linked filters are maintained here..';


--
-- Name: indicator_main; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE indicator_main (
    indmain integer DEFAULT nextval('ind_main_seq'::regclass) NOT NULL,
    ind_name text,
    numenator text,
    denominator text,
    formula_text text,
    result_text text,
    module_id integer,
    mt text,
    status smallint DEFAULT 1 NOT NULL
);


ALTER TABLE public.indicator_main OWNER TO postgres;

--
-- Name: COLUMN indicator_main.status; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN indicator_main.status IS 'status column will be used to identify is this indicator being used or not, 1 mean active, 0 mean inactive';


--
-- Name: indicators_periodic_multiplier; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE indicators_periodic_multiplier
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999999
    CACHE 1
    CYCLE;


ALTER TABLE public.indicators_periodic_multiplier OWNER TO postgres;

--
-- Name: indicator_periodic_multiplier; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE indicator_periodic_multiplier (
    pk_id integer DEFAULT nextval('indicators_periodic_multiplier'::regclass) NOT NULL,
    indicator character varying(128),
    start_year character varying(4),
    end_year character varying(4),
    formula_multiplier character varying(128),
    level character varying(1),
    code character varying(3)
);


ALTER TABLE public.indicator_periodic_multiplier OWNER TO postgres;

--
-- Name: login_log_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE login_log_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999999999999
    CACHE 1;


ALTER TABLE public.login_log_seq OWNER TO postgres;

--
-- Name: login_log; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE login_log (
    login_id integer DEFAULT nextval('login_log_seq'::regclass) NOT NULL,
    username character varying(50) NOT NULL,
    ip_address character varying(40) NOT NULL,
    system_info character varying(200) NOT NULL,
    login_date character varying(50) NOT NULL,
    success character varying(3) NOT NULL,
    login_time character varying(50),
    logout_time character varying(50)
);


ALTER TABLE public.login_log OWNER TO postgres;

--
-- Name: lookup_detail_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE lookup_detail_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.lookup_detail_seq OWNER TO postgres;

--
-- Name: lookup_detail; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE lookup_detail (
    pk_id integer DEFAULT nextval('lookup_detail_seq'::regclass) NOT NULL,
    value text,
    caption text,
    master_id integer,
    created_date date,
    created_by text,
    is_active character varying(1) DEFAULT 1 NOT NULL
);


ALTER TABLE public.lookup_detail OWNER TO postgres;

--
-- Name: lookup_master_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE lookup_master_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.lookup_master_seq OWNER TO postgres;

--
-- Name: lookup_master; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE lookup_master (
    pk_id integer DEFAULT nextval('lookup_master_seq'::regclass) NOT NULL,
    id integer,
    name text,
    label text,
    created_date date,
    created_by text
);


ALTER TABLE public.lookup_master OWNER TO postgres;

--
-- Name: manage_vacc_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE manage_vacc_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999999999999
    CACHE 1;


ALTER TABLE public.manage_vacc_id_seq OWNER TO postgres;

--
-- Name: manage_epi_vacc; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE manage_epi_vacc (
    recid integer DEFAULT nextval('manage_vacc_id_seq'::regclass) NOT NULL,
    distcode character varying(3),
    year character varying(4),
    month character varying(2),
    fmonth character varying(7),
    vaccinators_names character varying(500),
    uc_tot_pop integer,
    uc_annual_pop_less_1year integer,
    uncode character varying(9),
    uc_monthly_pop_less_1year integer,
    uc_annual_target_pop_women integer DEFAULT 0,
    uc_monthly_target_pop_women integer DEFAULT 0,
    vacc_code character varying(9) DEFAULT 0,
    submitted_date date,
    procode integer DEFAULT 3
);


ALTER TABLE public.manage_epi_vacc OWNER TO postgres;

--
-- Name: manage_vacc_items_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE manage_vacc_items_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999999999999
    CACHE 1;


ALTER TABLE public.manage_vacc_items_id_seq OWNER TO postgres;

--
-- Name: manage_epi_vacc_items_record; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE manage_epi_vacc_items_record (
    id integer DEFAULT nextval('manage_vacc_items_id_seq'::regclass) NOT NULL,
    opening_balance_quantity integer DEFAULT 0,
    recived_dur_month_date date,
    recived_dur_month_quantity integer DEFAULT 0,
    recived_dur_month_batch character varying(50),
    recived_dur_month_expiry date,
    utilized_during_month integer DEFAULT 0,
    end_balance_quantity integer DEFAULT 0,
    end_balance_expiry date,
    remarks character varying(500),
    uncode character varying(9),
    distcode character varying(3),
    fmonth character varying(7),
    vaccine_id integer DEFAULT 0,
    manage_vacc_id integer NOT NULL
);


ALTER TABLE public.manage_epi_vacc_items_record OWNER TO postgres;

--
-- Name: measle_case_investigation_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE measle_case_investigation_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999999999
    CACHE 1;


ALTER TABLE public.measle_case_investigation_id_seq OWNER TO postgres;

--
-- Name: measle_case_investigation; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE measle_case_investigation (
    id integer DEFAULT nextval('measle_case_investigation_id_seq'::regclass) NOT NULL,
    facode character varying(6),
    faddress text,
    uncode character varying(9),
    tcode character varying(6),
    distcode character varying(3),
    procode character varying(1),
    pvh_date date,
    case_epi_no character varying(30),
    patient_name character varying(100),
    patient_gender character varying(1),
    patient_fathername character varying(100),
    patient_dob date,
    age_months integer DEFAULT 0,
    patient_address text,
    patient_address_uncode character varying(9),
    patient_address_tcode character varying(6),
    patient_address_distcode character varying(3),
    patient_address_procode character varying(1),
    date_rash_onset date,
    last_dose_date date,
    specimen_type character varying(11),
    specimen_collection_date date,
    specimen_sent_lab_date date,
    followup_date date,
    outcome character varying(15),
    epid_year character varying(4),
    measles_number integer,
    dcode integer,
    complication character varying(18),
    death_date date,
    specimen_result character varying(18),
    form_completion_date date,
    week integer,
    datefrom date,
    dateto date,
    case_reported integer DEFAULT 1 NOT NULL,
    year character varying(4),
    type_specimen text,
    date_collection date,
    date_sent_lab date,
    fweek character varying(7),
    case_reported_t character varying(3),
    submitted_date date,
    editted_date date,
    date_investigation date,
    clinical_representation text,
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    doses_received integer,
    contact_numb character varying,
    cross_notified integer DEFAULT 0,
    cross_notified_from_distcode character varying(3) DEFAULT 0,
    approval_status character varying(10),
    rb_distcode character varying(3),
    rb_tcode character varying(6),
    rb_uncode character varying(9),
    rb_facode character varying(6),
    rb_faddress text,
    notification_date date,
    complications text
);


ALTER TABLE public.measle_case_investigation OWNER TO postgres;

--
-- Name: COLUMN measle_case_investigation.is_temp_saved; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN measle_case_investigation.is_temp_saved IS '0 means form is completely filled and saved from submit button, 1 means checklist is not completed and temporarily saved for re-edit later';


--
-- Name: measles_case_response_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE measles_case_response_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.measles_case_response_id OWNER TO postgres;

--
-- Name: measles_case_response; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE measles_case_response (
    id integer DEFAULT nextval('measles_case_response_id'::regclass) NOT NULL,
    uncode character varying(9),
    procode character varying(1) DEFAULT 3,
    distcode character varying(3),
    tcode character varying(6),
    village character varying(50),
    date_of_activity date,
    reported_case_surveillance integer,
    active_search_cases integer,
    epi_linked_cases integer,
    opv_0 integer,
    pcv_10_p1 integer,
    pcv_10_p2 integer,
    pcv_10_p3 integer,
    ipv integer,
    msl_1 integer,
    msl_2 integer,
    msl_booster_dose integer,
    tt_1 integer,
    tt_2 integer,
    age_group_selected_response integer,
    vitamin_a_administered text,
    health_education_sessions integer,
    blood_samples_sollected integer,
    oral_swabs_collected integer,
    follow_up_visit date,
    submitdate date,
    updatdate date
);


ALTER TABLE public.measles_case_response OWNER TO postgres;

--
-- Name: measles_outbreak_linelist_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE measles_outbreak_linelist_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.measles_outbreak_linelist_id_seq OWNER TO postgres;

--
-- Name: measles_outbreak_linelist; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE measles_outbreak_linelist (
    id integer DEFAULT nextval('measles_outbreak_linelist_id_seq'::regclass) NOT NULL,
    village_mahalla character varying(50),
    distcode character varying(3),
    date_investigation date,
    uncode character varying(9),
    tcode character varying(6),
    procode character varying(1),
    investigation_by character varying(50),
    fname_father character varying(100),
    case_epi_no character varying(26),
    age_in_months integer,
    gender character varying(6),
    child_address character varying(255),
    vacc_dose_no integer,
    date_last_dose date,
    date_rash_onset date,
    date_collection_blood date,
    date_collection_throat date,
    date_follow_up date,
    date_death date,
    complication character varying(100),
    linelist_group integer DEFAULT 0
);


ALTER TABLE public.measles_outbreak_linelist OWNER TO postgres;

--
-- Name: technician_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE technician_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999999
    CACHE 1;


ALTER TABLE public.technician_id_seq OWNER TO postgres;

--
-- Name: med_techniciandb; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE med_techniciandb (
    techniciancode character varying(9) NOT NULL,
    technicianname character varying(40) NOT NULL,
    husbandname character varying(40),
    fathername character varying(40),
    nic character varying(15),
    date_of_birth date,
    procode character varying(1) NOT NULL,
    distcode character varying(3) NOT NULL,
    facode character varying(6) NOT NULL,
    supervisorcode character varying(9),
    tcode character varying(8),
    uncode character varying(12),
    catch_area_pop integer,
    catch_area_name character varying(150),
    permanent_address character varying(120),
    present_address character varying(120),
    lastqualification character varying(15),
    passingyear integer,
    institutename character varying(120),
    date_joining date,
    place_of_joining character varying(30),
    date_termination date,
    status character varying(15),
    areatype character varying(15),
    basic_training_start_date date,
    basic_training_end_date date,
    id integer DEFAULT nextval('technician_id_seq'::regclass) NOT NULL,
    city character varying(15),
    phone character varying(20),
    marital_status character varying(15),
    designation character varying(30),
    bankaccountno character varying(30),
    payscale character varying(10),
    bid character varying(10),
    basicpay double precision,
    house_rent_allowance double precision,
    medical_allowance double precision,
    convence_allowance double precision,
    reason character varying(200),
    date_transfer date,
    date_died date,
    date_retired date,
    routine_epi_start_date date,
    routine_epi_end_date date,
    survilance_training_start_date date,
    survilance_training_end_date date,
    cold_chain_training_start_date date,
    cold_chain_training_end_date date,
    vlmis_training_start_date date,
    vlmis_training_end_date date,
    rec_training_end_date date,
    rec_training_start_date date,
    branchcode character varying(15),
    branchname character varying(50),
    employee_type character varying(50),
    imei text,
    pin integer,
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    date_resigned date,
    previous_table text,
    previous_code integer,
    date_to date,
    date_from date
);


ALTER TABLE public.med_techniciandb OWNER TO postgres;

--
-- Name: COLUMN med_techniciandb.is_temp_saved; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN med_techniciandb.is_temp_saved IS '0 means form is completely filled and saved from submit button, 1 means checklist is not completed and temporarily saved for re-edit later';


--
-- Name: menu_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE menu_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999
    CACHE 1;


ALTER TABLE public.menu_seq OWNER TO postgres;

--
-- Name: menu; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE menu (
    id integer DEFAULT nextval('menu_seq'::regclass) NOT NULL,
    menu_item text,
    menu_url character varying(500),
    icon character varying(250),
    parent_id character varying(5) DEFAULT '#'::character varying,
    template text
);


ALTER TABLE public.menu OWNER TO postgres;

--
-- Name: mfpdb_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE mfpdb_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.mfpdb_seq OWNER TO postgres;

--
-- Name: mfpdb; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE mfpdb (
    mfpcode character varying(5) NOT NULL,
    mfpname character varying(40),
    fathername character varying(40),
    nic character varying(20),
    date_of_birth date,
    procode character varying(1) DEFAULT '3'::character varying NOT NULL,
    distcode character varying(3) NOT NULL,
    tcode character varying(8),
    facode character varying(6),
    uncode character varying(12),
    permanent_address character varying(120),
    present_address character varying(120),
    postalcode character varying(15),
    city character varying(40),
    phone character varying(20),
    area_type character varying(20),
    status character varying(15),
    marital_status character varying(15),
    lastqualification character varying(15),
    passingyear integer,
    institutename character varying(120),
    date_joining date,
    place_of_joining character varying(80),
    place_of_posting character varying(80),
    designation character varying(80),
    bankaccountno character varying(30),
    payscale character varying(10),
    bid character varying(6),
    basicpay double precision,
    husbandname character varying(50),
    date_termination date,
    date_transfer date,
    date_died date,
    date_retired date,
    m_id integer DEFAULT nextval('mfpdb_seq'::regclass) NOT NULL,
    branchcode character varying(15),
    branchname character varying(50),
    employee_type character varying(15),
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    basic_training_start_date date,
    basic_training_end_date date,
    routine_epi_start_date date,
    routine_epi_end_date date,
    survilance_training_start_date date,
    survilance_training_end_date date,
    cold_chain_training_start_date date,
    cold_chain_training_end_date date,
    vlmis_training_start_date date,
    vlmis_training_end_date date,
    previouse_code character varying(9),
    date_resigned date,
    reason text,
    previous_table text,
    previous_code integer,
    date_from date,
    date_to date
);


ALTER TABLE public.mfpdb OWNER TO postgres;

--
-- Name: monthly_outuc_coverage_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE monthly_outuc_coverage_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999999999999999
    CACHE 1;


ALTER TABLE public.monthly_outuc_coverage_seq OWNER TO postgres;

--
-- Name: monthly_outuc_coverage; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE monthly_outuc_coverage (
    pk_id integer DEFAULT nextval('monthly_outuc_coverage_seq'::regclass) NOT NULL,
    from_facode integer NOT NULL,
    item_id integer DEFAULT 0,
    fm1 integer DEFAULT 0,
    ff1 integer DEFAULT 0,
    om1 integer DEFAULT 0,
    of1 integer DEFAULT 0,
    mm1 integer DEFAULT 0,
    mf1 integer DEFAULT 0,
    hm1 integer DEFAULT 0,
    hf1 integer DEFAULT 0,
    fm2 integer DEFAULT 0,
    ff2 integer DEFAULT 0,
    om2 integer DEFAULT 0,
    of2 integer DEFAULT 0,
    mm2 integer DEFAULT 0,
    mf2 integer DEFAULT 0,
    hm2 integer DEFAULT 0,
    hf2 integer DEFAULT 0,
    fm3 integer DEFAULT 0,
    ff3 integer DEFAULT 0,
    om3 integer DEFAULT 0,
    of3 integer DEFAULT 0,
    mm3 integer DEFAULT 0,
    mf3 integer DEFAULT 0,
    hm3 integer DEFAULT 0,
    hf3 integer DEFAULT 0,
    fmonth character varying(7) NOT NULL,
    uncode character varying(9) NOT NULL,
    tcode character varying(6) NOT NULL,
    distcode character varying(3) NOT NULL,
    procode character varying(1) NOT NULL,
    submitted_datetime timestamp without time zone NOT NULL,
    updated_datetime timestamp without time zone,
    antigen integer,
    fp integer DEFAULT 0,
    fnp integer DEFAULT 0,
    op integer DEFAULT 0,
    onp integer DEFAULT 0,
    mp integer DEFAULT 0,
    mnp integer DEFAULT 0,
    hp integer DEFAULT 0,
    hnp integer DEFAULT 0,
    countrycode character varying(5) DEFAULT 92
);


ALTER TABLE public.monthly_outuc_coverage OWNER TO postgres;

--
-- Name: msr_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE msr_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999999
    CACHE 1;


ALTER TABLE public.msr_id_seq OWNER TO postgres;

--
-- Name: msr; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE msr (
    id integer DEFAULT nextval('msr_id_seq'::regclass) NOT NULL,
    procode character varying(1) DEFAULT '3'::character varying NOT NULL,
    distcode character varying(3) NOT NULL,
    facode character varying(6) NOT NULL,
    fmonth character varying(7) NOT NULL,
    sr_r1_f1 integer DEFAULT 0,
    sr_r1_f2 integer DEFAULT 0,
    sr_r1_f3 integer DEFAULT 0,
    sr_r1_f4 integer DEFAULT 0,
    sr_r1_f5 integer DEFAULT 0,
    sr_r1_f6 integer DEFAULT 0,
    sr_r1_f7 integer DEFAULT 0,
    sr_r1_f8 integer DEFAULT 0,
    sr_r1_f9 integer DEFAULT 0,
    sr_r2_f1 integer DEFAULT 0,
    sr_r2_f2 integer DEFAULT 0,
    sr_r2_f3 integer DEFAULT 0,
    sr_r2_f4 integer DEFAULT 0,
    sr_r2_f5 integer DEFAULT 0,
    sr_r2_f6 integer DEFAULT 0,
    sr_r2_f7 integer DEFAULT 0,
    sr_r2_f8 integer DEFAULT 0,
    sr_r2_f9 integer DEFAULT 0,
    sr_r3_f1 integer DEFAULT 0,
    sr_r3_f2 integer DEFAULT 0,
    sr_r3_f3 integer DEFAULT 0,
    sr_r3_f4 integer DEFAULT 0,
    sr_r3_f5 integer DEFAULT 0,
    sr_r3_f6 integer DEFAULT 0,
    sr_r3_f7 integer DEFAULT 0,
    sr_r3_f8 integer DEFAULT 0,
    sr_r3_f9 integer DEFAULT 0,
    sr_r4_f1 integer DEFAULT 0,
    sr_r4_f2 integer DEFAULT 0,
    sr_r4_f3 integer DEFAULT 0,
    sr_r4_f4 integer DEFAULT 0,
    sr_r4_f5 integer DEFAULT 0,
    sr_r4_f6 integer DEFAULT 0,
    sr_r4_f7 integer DEFAULT 0,
    sr_r4_f8 integer DEFAULT 0,
    sr_r4_f9 integer DEFAULT 0,
    sr_r5_f1 integer DEFAULT 0,
    sr_r5_f2 integer DEFAULT 0,
    sr_r5_f3 integer DEFAULT 0,
    sr_r5_f4 integer DEFAULT 0,
    sr_r5_f5 integer DEFAULT 0,
    sr_r5_f6 integer DEFAULT 0,
    sr_r5_f7 integer DEFAULT 0,
    sr_r5_f8 integer DEFAULT 0,
    sr_r5_f9 integer DEFAULT 0,
    sr_r6_f1 integer DEFAULT 0,
    sr_r6_f2 integer DEFAULT 0,
    sr_r6_f3 integer DEFAULT 0,
    sr_r6_f4 integer DEFAULT 0,
    sr_r6_f5 integer DEFAULT 0,
    sr_r6_f6 integer DEFAULT 0,
    sr_r6_f7 integer DEFAULT 0,
    sr_r6_f8 integer DEFAULT 0,
    sr_r6_f9 integer DEFAULT 0,
    sr_r7_f1 integer DEFAULT 0,
    sr_r7_f2 integer DEFAULT 0,
    sr_r7_f3 integer DEFAULT 0,
    sr_r7_f4 integer DEFAULT 0,
    sr_r7_f5 integer DEFAULT 0,
    sr_r7_f6 integer DEFAULT 0,
    sr_r7_f7 integer DEFAULT 0,
    sr_r7_f8 integer DEFAULT 0,
    sr_r7_f9 integer DEFAULT 0,
    sr_r8_f1 integer DEFAULT 0,
    sr_r8_f2 integer DEFAULT 0,
    sr_r8_f3 integer DEFAULT 0,
    sr_r8_f4 integer DEFAULT 0,
    sr_r8_f5 integer DEFAULT 0,
    sr_r8_f6 integer DEFAULT 0,
    sr_r8_f7 integer DEFAULT 0,
    sr_r8_f8 integer DEFAULT 0,
    sr_r8_f9 integer DEFAULT 0,
    sr_r9_f1 integer DEFAULT 0,
    sr_r9_f2 integer DEFAULT 0,
    sr_r9_f3 integer DEFAULT 0,
    sr_r9_f4 integer DEFAULT 0,
    sr_r9_f5 integer DEFAULT 0,
    sr_r9_f6 integer DEFAULT 0,
    sr_r9_f7 integer DEFAULT 0,
    sr_r9_f8 integer DEFAULT 0,
    sr_r9_f9 integer DEFAULT 0,
    epi_cord_name text,
    epi_demiologist_name text
);


ALTER TABLE public.msr OWNER TO postgres;

--
-- Name: nnt_cases_linelist_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE nnt_cases_linelist_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.nnt_cases_linelist_id_seq OWNER TO postgres;

--
-- Name: nnt_cases_linelist; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE nnt_cases_linelist (
    id integer DEFAULT nextval('nnt_cases_linelist_id_seq'::regclass) NOT NULL,
    reported_from character varying(50),
    case_epi_no character varying(23),
    fname_father character varying(100),
    age_in_days integer,
    gender character varying(6),
    contact_no character varying(15),
    village character varying(50),
    uncode character varying(9),
    tcode character varying(6),
    distcode character varying(3),
    procode character varying(1),
    tt_doses_mother integer,
    signs_symptoms character varying(50),
    date_onset date,
    date_notification date,
    date_investigation date,
    diagnosed_by character varying(50),
    out_come character varying(100),
    antenatal_visits integer,
    date_delivery date,
    delivery_by character varying(50),
    place_of_delivery character varying(100),
    instrument_cord character varying(50),
    cord_clamping_material character varying(50),
    linelist_group integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.nnt_cases_linelist OWNER TO postgres;

--
-- Name: nnt_investigation_form_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE nnt_investigation_form_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.nnt_investigation_form_id_seq OWNER TO postgres;

--
-- Name: nnt_investigation_form; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE nnt_investigation_form (
    id integer DEFAULT nextval('nnt_investigation_form_id_seq'::regclass) NOT NULL,
    date_notification date,
    reported_by character varying(100),
    reported_from character varying(100),
    mode_reporting character varying(255),
    active_sur_visit character varying(3),
    informed_by_call character varying(3),
    identified_weekly_data character varying(3),
    date_investigation date,
    place_investigation text,
    investigated_by character varying(100),
    cases text,
    deaths text,
    full_mother_name character varying(150),
    head_full_name character varying(150),
    house_hold_address character varying(255),
    baby_dob date,
    gender character varying(6),
    ethnic_group character varying(255),
    doses_received integer,
    card_date1 date,
    card_date2 date,
    card_date3 date,
    card_date4 date,
    card_date5 date,
    pregnancy_visits integer,
    facode1 character varying(6),
    facode2 character varying(6),
    facode3 character varying(6),
    where_baby_delivered character varying(255),
    cord_treated text,
    n_facode character varying(6),
    address character varying(255),
    med_record_number character varying(255),
    date_admission date,
    bs_normal_birth character varying(7),
    bs_days integer,
    bs_days_unknown character varying(3),
    bs_cry character varying(7),
    bs_stop_sucking character varying(7),
    bs_stiffness character varying(7),
    bs_spasms character varying(7),
    bs_case_confirmed character varying(7),
    tr_cared character varying(7),
    tr_facode character varying(6),
    tr_distcode character varying(3),
    tr_baby_died character varying(7),
    b_death_date date,
    tr_mother_died character varying(7),
    m_death_date date,
    cr_mother_immunized character varying(7),
    cr_immunized_date date,
    cr_case_response character varying(7),
    cr_numb_women_vaccinated integer,
    cr_case_search character varying(7),
    cr_numb_nt_cases integer,
    cr_vaccine_importance text,
    follow_up_visits integer,
    immunization_history character varying(10),
    date_notification_level date,
    year integer,
    procode character varying(1),
    nnt_confirmed character varying(7),
    instrument_used character varying(100),
    distcode character varying(3),
    tcode character varying(6),
    uncode character varying(9),
    facode character varying(6),
    dcode integer,
    nnt_distcode character varying(3),
    nnt_tcode character varying(6),
    nnt_uncode character varying(9),
    nnt_facode character varying(6),
    place_investigation_facode character varying(6),
    fweek character varying(7),
    week integer,
    datefrom date,
    dateto date,
    case_reported integer DEFAULT 1 NOT NULL,
    submitted_date date,
    editted_date date,
    clinical_representation text,
    date_onset date,
    diagnosed_by character varying(100),
    date_delivery date,
    age_months integer DEFAULT 0,
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    cross_notified_from_distcode character varying(3),
    approval_status character varying(10),
    cross_notified integer DEFAULT 0,
    rb_distcode character varying(3),
    rb_tcode character varying(6),
    rb_uncode character varying(9),
    rb_facode character varying(6),
    rb_faddress text,
    nnt_procode character varying(1),
    cn_id_from integer DEFAULT 0,
    cn_id_to integer DEFAULT 0,
    cross_case_id text,
    cry_become_stiff_or_has_spasms text,
    contact_numb character varying(15)
);


ALTER TABLE public.nnt_investigation_form OWNER TO postgres;

--
-- Name: COLUMN nnt_investigation_form.is_temp_saved; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN nnt_investigation_form.is_temp_saved IS '0 means form is completely filled and saved from submit button, 1 means checklist is not completed and temporarily saved for re-edit later';


--
-- Name: number_hf; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE number_hf (
    count bigint
);


ALTER TABLE public.number_hf OWNER TO postgres;

--
-- Name: output; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE output (
    "coalesce" double precision
);


ALTER TABLE public.output OWNER TO postgres;

--
-- Name: pertsis_outbreak_linelist_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE pertsis_outbreak_linelist_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.pertsis_outbreak_linelist_id_seq OWNER TO postgres;

--
-- Name: pertussis_outbreak_linelist; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE pertussis_outbreak_linelist (
    id integer DEFAULT nextval('pertsis_outbreak_linelist_id_seq'::regclass) NOT NULL,
    village_mahalla character varying(50),
    distcode character varying(3),
    date_investigation date,
    uncode character varying(9),
    tcode character varying(6),
    procode character varying(1),
    investigation_by character varying(50),
    fname_father character varying(100),
    case_epi_no character varying(26),
    age_in_months integer,
    gender character varying(6),
    child_address character varying(255),
    vacc_dose_no integer,
    date_last_dose date,
    date_rash_onset date,
    date_collection_blood date,
    date_collection_throat date,
    date_follow_up date,
    date_death date,
    complication character varying(100),
    linelist_group integer DEFAULT 0,
    date_submitted date
);


ALTER TABLE public.pertussis_outbreak_linelist OWNER TO postgres;

--
-- Name: pneumonia_outbreak_linelist_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE pneumonia_outbreak_linelist_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.pneumonia_outbreak_linelist_id_seq OWNER TO postgres;

--
-- Name: pneumonia_outbreak_linelist; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE pneumonia_outbreak_linelist (
    id integer DEFAULT nextval('pneumonia_outbreak_linelist_id_seq'::regclass) NOT NULL,
    village_mahalla character varying(50),
    distcode character varying(3),
    date_investigation date,
    uncode character varying(9),
    tcode character varying(6),
    procode character varying(1),
    investigation_by character varying(50),
    fname_father character varying(100),
    case_epi_no character varying(26),
    age_in_months integer,
    gender character varying(6),
    child_address character varying(255),
    vacc_dose_no integer,
    date_last_dose date,
    date_rash_onset date,
    date_collection_blood date,
    date_collection_throat date,
    date_follow_up date,
    date_death date,
    complication character varying(100),
    linelist_group integer DEFAULT 0,
    date_submitted date
);


ALTER TABLE public.pneumonia_outbreak_linelist OWNER TO postgres;

--
-- Name: pop; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE pop (
    population integer
);


ALTER TABLE public.pop OWNER TO postgres;

--
-- Name: products_details; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE products_details (
    id integer NOT NULL,
    product_id character varying(50) NOT NULL,
    name character varying(50) NOT NULL,
    doses integer,
    id_to_search integer DEFAULT 0 NOT NULL,
    item_pack_size_id integer
);


ALTER TABLE public.products_details OWNER TO postgres;

--
-- Name: COLUMN products_details.id_to_search; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN products_details.id_to_search IS 'this is id saved in province to district issue database. now we need to match this to get exact data. This id is located in ''form_a1_vaccine_title''';


--
-- Name: products_doses_details; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE products_doses_details (
    id integer NOT NULL,
    cr_product_id integer NOT NULL,
    vacc_dose_id integer NOT NULL
);


ALTER TABLE public.products_doses_details OWNER TO postgres;

--
-- Name: TABLE products_doses_details; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE products_doses_details IS 'This is a mapping table for Consumption and requisition products with its doses that resides in EPI Vaccination products.';


--
-- Name: COLUMN products_doses_details.cr_product_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN products_doses_details.cr_product_id IS 'Consumption and requision form product id';


--
-- Name: COLUMN products_doses_details.vacc_dose_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN products_doses_details.vacc_dose_id IS 'Epi Vaccination form dose id of product';


--
-- Name: province_population_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE province_population_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999
    CACHE 1
    CYCLE;


ALTER TABLE public.province_population_id_seq OWNER TO postgres;

--
-- Name: province_population; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE province_population (
    id integer DEFAULT nextval('province_population_id_seq'::regclass) NOT NULL,
    procode character varying(3),
    year character varying(4),
    population integer,
    created_date date,
    update_date date,
    update_by text
);


ALTER TABLE public.province_population OWNER TO postgres;

--
-- Name: provinces_pro_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE provinces_pro_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.provinces_pro_seq OWNER TO postgres;

--
-- Name: provinces; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE provinces (
    pro_id integer DEFAULT nextval('provinces_pro_seq'::regclass) NOT NULL,
    province character varying(100),
    procode character varying(3),
    population character varying(10),
    shortname character varying(4),
    highchart_coordinates text,
    weburl text,
    localurl text
);


ALTER TABLE public.provinces OWNER TO postgres;

--
-- Name: red_strategy_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE red_strategy_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.red_strategy_seq OWNER TO postgres;

--
-- Name: red_strategy_db; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE red_strategy_db (
    recid integer DEFAULT nextval('red_strategy_seq'::regclass) NOT NULL,
    procode character varying(1) DEFAULT 3,
    distcode character varying(3) NOT NULL,
    tcode character varying(6) NOT NULL,
    uncode character varying(9),
    facode character varying(6) NOT NULL,
    year character varying(4) NOT NULL,
    month character varying(2),
    problems_r1_c1 text,
    actlimitres_r1_c2 text,
    actneedresources_r1_c3 text,
    date_r1_c4 date,
    area_r1_c5 character varying(255),
    person_r1_c6 character varying(100),
    problems_r2_c1 text,
    actlimitres_r2_c2 text,
    actneedresources_r2_c3 text,
    date_r2_c4 date,
    area_r2_c5 character varying(255),
    person_r2_c6 character varying(100),
    problems_r3_c1 text,
    actlimitres_r3_c2 text,
    actneedresources_r3_c3 text,
    date_r3_c4 date,
    area_r3_c5 character varying(255),
    person_r3_c6 character varying(100),
    problems_r4_c1 text,
    actlimitres_r4_c2 text,
    actneedresources_r4_c3 text,
    date_r4_c4 date,
    area_r4_c5 character varying(255),
    person_r4_c6 character varying(100),
    problems_r5_c1 text,
    actlimitres_r5_c2 text,
    actneedresources_r5_c3 text,
    date_r5_c4 date,
    area_r5_c5 character varying(255),
    person_r5_c6 character varying(100),
    q1 integer DEFAULT 0,
    q2 integer DEFAULT 0,
    q3 integer DEFAULT 0,
    q4 integer DEFAULT 0,
    submitted_date date NOT NULL,
    updated_date date
);


ALTER TABLE public.red_strategy_db OWNER TO postgres;

--
-- Name: requisitionform_vaccine_titles; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE requisitionform_vaccine_titles (
    vacc_id integer,
    vacc_name character varying(50)
);


ALTER TABLE public.requisitionform_vaccine_titles OWNER TO postgres;

--
-- Name: roles_menu_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE roles_menu_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999
    CACHE 1;


ALTER TABLE public.roles_menu_seq OWNER TO postgres;

--
-- Name: roles_menu; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE roles_menu (
    id integer DEFAULT nextval('roles_menu_seq'::regclass) NOT NULL,
    role_id integer,
    menu_id integer,
    active integer NOT NULL
);


ALTER TABLE public.roles_menu OWNER TO postgres;

--
-- Name: sanctioned_posts_db_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sanctioned_posts_db_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sanctioned_posts_db_seq OWNER TO postgres;

--
-- Name: sanctioned_posts_db; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sanctioned_posts_db (
    recid integer DEFAULT nextval('sanctioned_posts_db_seq'::regclass) NOT NULL,
    procode character varying(1) DEFAULT 3 NOT NULL,
    distcode character varying(3) NOT NULL,
    dso integer DEFAULT 0,
    computer_operator integer DEFAULT 0,
    hf_incharge integer DEFAULT 0,
    store_keeper integer DEFAULT 0,
    epi_tech integer DEFAULT 0,
    driver integer DEFAULT 0,
    epi_coordinator integer DEFAULT 0,
    dsv integer DEFAULT 0,
    tsv integer DEFAULT 0,
    asv integer DEFAULT 0,
    cc_technician integer DEFAULT 0,
    cc_operator integer DEFAULT 0,
    cc_mechanic integer DEFAULT 0,
    epi_coordinator_fill integer DEFAULT 0,
    dsv_fill integer DEFAULT 0,
    tsv_fill integer DEFAULT 0,
    asv_fill integer DEFAULT 0,
    cc_technician_fill integer DEFAULT 0,
    cc_operator_fill integer DEFAULT 0,
    cc_mechanic_fill integer DEFAULT 0,
    cc_generator integer DEFAULT 0,
    cc_generator_fill integer DEFAULT 0,
    dso_fill integer DEFAULT 0,
    computer_operator_fill integer DEFAULT 0,
    hf_incharge_fill integer DEFAULT 0,
    epi_tech_fill integer DEFAULT 0,
    store_keeper_fill integer DEFAULT 0,
    driver_fill integer DEFAULT 0
);


ALTER TABLE public.sanctioned_posts_db OWNER TO postgres;

--
-- Name: session_plan_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE session_plan_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
    CYCLE;


ALTER TABLE public.session_plan_seq OWNER TO postgres;

--
-- Name: session_plan_db; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE session_plan_db (
    recid integer DEFAULT nextval('session_plan_seq'::regclass) NOT NULL,
    procode character varying(1) DEFAULT 3,
    distcode character varying(3) NOT NULL,
    tcode character varying(6) NOT NULL,
    uncode character varying(9),
    facode character varying(6) NOT NULL,
    year character varying(4) NOT NULL,
    month character varying(2),
    area_name character varying(255) NOT NULL,
    total_population integer DEFAULT 0,
    target_population integer DEFAULT 0,
    session_type character varying(20),
    injections_per_year integer DEFAULT 0,
    injections_per_month double precision DEFAULT 0,
    estimated_sessions integer DEFAULT 0,
    sessions_per_month double precision DEFAULT 0,
    actual_sessions_plan integer DEFAULT 0,
    child_survival_interventions character varying(255),
    hard_to_reach character varying(3),
    hard_to_reach_population double precision DEFAULT 0,
    q1 integer DEFAULT 0,
    q2 integer DEFAULT 0,
    q3 integer DEFAULT 0,
    q4 integer DEFAULT 0,
    submitted_date date NOT NULL,
    updated_date date
);


ALTER TABLE public.session_plan_db OWNER TO postgres;

--
-- Name: situation_analysis_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE situation_analysis_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.situation_analysis_seq OWNER TO postgres;

--
-- Name: situation_analysis_db; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE situation_analysis_db (
    recid integer DEFAULT nextval('situation_analysis_seq'::regclass) NOT NULL,
    procode character varying(1) DEFAULT 3,
    distcode character varying(3) NOT NULL,
    tcode character varying(6) NOT NULL,
    uncode character varying(9),
    facode character varying(6) NOT NULL,
    year character varying(4) NOT NULL,
    month character varying(2),
    area_name character varying(255) NOT NULL,
    less_one_year integer DEFAULT 0,
    penta1 integer DEFAULT 0,
    penta3 integer DEFAULT 0,
    measles integer DEFAULT 0,
    tt2 integer DEFAULT 0,
    penta1_percent double precision DEFAULT 0,
    penta3_percent double precision DEFAULT 0,
    measles_percent double precision DEFAULT 0,
    tt2_percent double precision DEFAULT 0,
    penta3_not integer DEFAULT 0,
    measles_not integer DEFAULT 0,
    penta1penta3 double precision DEFAULT 0,
    penta1measles double precision DEFAULT 0,
    access character varying(50),
    utilization character varying(50),
    category integer DEFAULT 0,
    priority integer DEFAULT 0,
    q1 integer DEFAULT 0,
    q2 integer DEFAULT 0,
    q3 integer DEFAULT 0,
    q4 integer DEFAULT 0,
    submitted_date date NOT NULL,
    updated_date date,
    f2_hard_to_reach character varying(3),
    f2_reached_last_year integer DEFAULT 0,
    f2_activities_improve_hf character varying(225),
    f2_activities_need_support character varying(225),
    f2_interventions_delivered character varying(225),
    f2_q1 integer DEFAULT 0,
    f2_q2 integer DEFAULT 0,
    f2_q3 integer DEFAULT 0,
    f2_q4 integer DEFAULT 0,
    f3_total_population integer DEFAULT 0,
    f3_target_population integer DEFAULT 0,
    f3_session_type character varying(20),
    f3_injections_per_year integer DEFAULT 0,
    f3_injections_per_month double precision DEFAULT 0,
    f3_estimated_sessions integer DEFAULT 0,
    f3_sessions_per_month double precision DEFAULT 0,
    f3_actual_sessions_plan integer DEFAULT 0,
    f3_child_survival_interventions character varying(225),
    f3_hard_to_reach character varying(3),
    f3_hard_to_reach_population double precision DEFAULT 0,
    f3_q1 integer DEFAULT 0,
    f3_q2 integer DEFAULT 0,
    f3_q3 integer DEFAULT 0,
    f3_q4 integer DEFAULT 0,
    f4_problems_r1_c1 text,
    f4_actlimitres_r1_c2 text,
    f4_actneedresources_r1_c3 text,
    f4_date_r1_c4 date,
    f4_area_r1_c5 character varying(225),
    f4_person_r1_c6 character varying(100),
    f4_problems_r2_c1 text,
    f4_actlimitres_r2_c2 text,
    f4_actneedresources_r2_c3 text,
    f4_date_r2_c4 date,
    f4_area_r2_c5 character varying(225),
    f4_person_r2_c6 character varying(100),
    f4_problems_r3_c1 text,
    f4_actlimitres_r3_c2 text,
    f4_actneedresources_r3_c3 text,
    f4_date_r3_c4 date,
    f4_area_r3_c5 character varying(225),
    f4_person_r3_c6 character varying(100),
    f4_problems_r4_c1 text,
    f4_actlimitres_r4_c2 text,
    f4_actneedresources_r4_c3 text,
    f4_date_r4_c4 date,
    f4_area_r4_c5 character varying(225),
    f4_person_r4_c6 character varying(100),
    f4_problems_r5_c1 text,
    f4_actlimitres_r5_c2 text,
    f4_actneedresources_r5_c3 text,
    f4_date_r5_c4 date,
    f4_area_r5_c5 character varying(225),
    f4_person_r5_c6 character varying(100),
    techniciancode character varying(9) NOT NULL,
    "Group_id" integer,
    red_map text,
    date_red_map date
);


ALTER TABLE public.situation_analysis_db OWNER TO postgres;

--
-- Name: skdb_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE skdb_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999
    CACHE 1;


ALTER TABLE public.skdb_seq OWNER TO postgres;

--
-- Name: skdb; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE skdb (
    skcode character varying(7) NOT NULL,
    skname character varying(40),
    fathername character varying(40),
    nic character varying(20),
    date_of_birth date,
    procode character varying(1) DEFAULT '2'::character varying NOT NULL,
    distcode character varying(3) NOT NULL,
    tcode character varying(8),
    facode character varying(6),
    uncode character varying(12),
    permanent_address character varying(120),
    present_address character varying(120),
    postalcode character varying(15),
    city character varying(40),
    phone character varying(20),
    area_type character varying(20),
    status character varying(15),
    marital_status character varying(15),
    lastqualification character varying(15),
    passingyear integer,
    institutename character varying(120),
    date_joining date,
    place_of_joining character varying(80),
    place_of_posting character varying(80),
    designation character varying(80),
    bankaccountno character varying(30),
    payscale character varying(10),
    bid character varying(6),
    basicpay double precision,
    husbandname character varying(50),
    date_termination date,
    date_transfer date,
    date_died date,
    date_retired date,
    sk_id integer DEFAULT nextval('skdb_seq'::regclass) NOT NULL,
    branchcode character varying(15),
    branchname character varying(50),
    employee_type character varying(15),
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    previous_code character varying(9),
    current_status text,
    basic_training_start_date date,
    basic_training_end_date date,
    routine_epi_start_date date,
    routine_epi_end_date date,
    survilance_training_start_date date,
    survilance_training_end_date date,
    cold_chain_training_start_date date,
    cold_chain_training_end_date date,
    vlmis_training_start_date date,
    vlmis_training_end_date date,
    reason text,
    date_resigned date,
    previous_table text,
    date_from date,
    date_to date
);


ALTER TABLE public.skdb OWNER TO postgres;

--
-- Name: special_activities_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE special_activities_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.special_activities_seq OWNER TO postgres;

--
-- Name: special_activities_db; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE special_activities_db (
    recid integer DEFAULT nextval('special_activities_seq'::regclass) NOT NULL,
    procode character varying(1) DEFAULT 3,
    distcode character varying(3) NOT NULL,
    tcode character varying(6) NOT NULL,
    uncode character varying(9),
    facode character varying(6) NOT NULL,
    year character varying(4) NOT NULL,
    month character varying(2),
    area_name character varying(255) NOT NULL,
    category integer DEFAULT 0,
    hard_to_reach character varying(3),
    reached_last_year integer DEFAULT 0,
    activities_improve_hf character varying(255),
    activities_need_support character varying(255),
    interventions_delivered character varying(255),
    q1 integer DEFAULT 0,
    q2 integer DEFAULT 0,
    q3 integer DEFAULT 0,
    q4 integer DEFAULT 0,
    submitted_date date NOT NULL,
    updated_date date
);


ALTER TABLE public.special_activities_db OWNER TO postgres;

--
-- Name: stakeholder_activities_pkid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE stakeholder_activities_pkid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2739999999
    CACHE 1;


ALTER TABLE public.stakeholder_activities_pkid_seq OWNER TO postgres;

--
-- Name: stakeholder_activities; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE stakeholder_activities (
    pk_id integer DEFAULT nextval('stakeholder_activities_pkid_seq'::regclass) NOT NULL,
    activity character varying(255) DEFAULT NULL::character varying,
    created_by integer DEFAULT 1 NOT NULL,
    created_date date,
    modified_by integer DEFAULT 1 NOT NULL,
    modified_date timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.stakeholder_activities OWNER TO postgres;

--
-- Name: stakeholder_item_pack_sizes_pkid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE stakeholder_item_pack_sizes_pkid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2739999999
    CACHE 1;


ALTER TABLE public.stakeholder_item_pack_sizes_pkid_seq OWNER TO postgres;

--
-- Name: stakeholder_item_pack_sizes; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE stakeholder_item_pack_sizes (
    pk_id integer DEFAULT nextval('stakeholder_item_pack_sizes_pkid_seq'::regclass) NOT NULL,
    pack_size_description text,
    length numeric(11,2) DEFAULT NULL::numeric,
    width numeric(11,2) DEFAULT NULL::numeric,
    height numeric(11,2) DEFAULT NULL::numeric,
    quantity_per_pack integer,
    list_rank integer,
    volum_per_vial numeric(10,2) DEFAULT NULL::numeric,
    item_gtin character varying(20) DEFAULT NULL::character varying,
    packaging_level integer DEFAULT 140,
    stakeholder_id integer,
    item_pack_size_id integer,
    created_by integer DEFAULT 1 NOT NULL,
    created_date date,
    modified_by integer DEFAULT 1 NOT NULL,
    modified_date timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.stakeholder_item_pack_sizes OWNER TO postgres;

--
-- Name: stakeholder_sectors_pkid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE stakeholder_sectors_pkid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2739999999
    CACHE 1;


ALTER TABLE public.stakeholder_sectors_pkid_seq OWNER TO postgres;

--
-- Name: stakeholder_sectors; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE stakeholder_sectors (
    pk_id integer DEFAULT nextval('stakeholder_sectors_pkid_seq'::regclass) NOT NULL,
    stakeholder_sector_name character varying(100) DEFAULT NULL::character varying,
    created_by integer DEFAULT 1 NOT NULL,
    created_date date,
    modified_by integer DEFAULT 1 NOT NULL,
    modified_date timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.stakeholder_sectors OWNER TO postgres;

--
-- Name: stakeholder_types_pkid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE stakeholder_types_pkid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2739999999
    CACHE 1;


ALTER TABLE public.stakeholder_types_pkid_seq OWNER TO postgres;

--
-- Name: stakeholder_types; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE stakeholder_types (
    pk_id integer DEFAULT nextval('stakeholder_types_pkid_seq'::regclass) NOT NULL,
    stakeholder_type_name character varying(100) DEFAULT NULL::character varying,
    created_by integer DEFAULT 1 NOT NULL,
    created_date date,
    modified_by integer DEFAULT 1 NOT NULL,
    modified_date timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.stakeholder_types OWNER TO postgres;

--
-- Name: stakeholders_pkid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE stakeholders_pkid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2739999999
    CACHE 1;


ALTER TABLE public.stakeholders_pkid_seq OWNER TO postgres;

--
-- Name: stakeholders; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE stakeholders (
    pk_id integer DEFAULT nextval('stakeholders_pkid_seq'::regclass) NOT NULL,
    stakeholder_name character varying(100) DEFAULT NULL::character varying,
    parent_id integer NOT NULL,
    stakeholder_type_id integer DEFAULT 0 NOT NULL,
    stakeholder_sector_id integer NOT NULL,
    geo_level_id integer NOT NULL,
    main_stakeholder integer,
    stakeholder_activity_id integer,
    created_by integer DEFAULT 1 NOT NULL,
    created_date date,
    modified_by integer DEFAULT 1 NOT NULL,
    modified_date timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.stakeholders OWNER TO postgres;

--
-- Name: stock_master_trans_num_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE stock_master_trans_num_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999
    CACHE 1
    CYCLE;


ALTER TABLE public.stock_master_trans_num_seq OWNER TO postgres;

--
-- Name: sub_indicators; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sub_indicators (
    pk_id integer NOT NULL,
    name character varying(150) NOT NULL,
    indicator_id integer NOT NULL,
    module_id integer NOT NULL,
    "order" integer NOT NULL,
    active integer DEFAULT 1 NOT NULL,
    result_table character varying(30),
    result_format character varying(15),
    denominator_formula integer,
    multiplier integer DEFAULT 100,
    formula_string character varying(30)
);


ALTER TABLE public.sub_indicators OWNER TO postgres;

--
-- Name: TABLE sub_indicators; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE sub_indicators IS 'All Sub Indicators linked to individual indicator will be listed here..';


--
-- Name: supervisor_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE supervisor_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.supervisor_id_seq OWNER TO postgres;

--
-- Name: supervisordb; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE supervisordb (
    supervisorcode character varying(7) NOT NULL,
    supervisorname character varying(40) NOT NULL,
    fathername character varying(40),
    nic character varying(15),
    date_of_birth date,
    procode character varying(1) NOT NULL,
    distcode character varying(3),
    facode character varying(6),
    tcode character varying(8),
    uncode character varying(12),
    catch_area_pop integer,
    catch_area_name character varying(60),
    permanent_address character varying(120),
    present_address character varying(120),
    lastqualification character varying(15),
    passingyear integer,
    institutename character varying(120),
    date_joining date,
    place_of_joining character varying(200),
    date_termination date,
    status character varying(15),
    areatype character varying(6),
    basic_training_start_date date,
    basic_training_end_date date,
    routine_epi_start_date date,
    routine_epi_end_date date,
    id integer DEFAULT nextval('supervisor_id_seq'::regclass) NOT NULL,
    city character varying(50),
    phone character varying(30),
    marital_status character varying(40),
    designation character varying(50),
    bankaccountno character varying(40),
    payscale character varying(30),
    bid character varying(10),
    basicpay double precision,
    date_transfer date,
    date_died date,
    date_retired date,
    survilance_training_start_date date,
    survilance_training_end_date date,
    cold_chain_training_start_date date,
    cold_chain_training_end_date date,
    vlmis_training_start_date date,
    vlmis_training_end_date date,
    rec_training_start_date date,
    rec_training_end_date date,
    branchcode character varying(15),
    branchname character varying(50),
    employee_type character varying(50),
    supervisor_type character varying(60),
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    current_status text,
    previous_code character varying(9),
    date_resigned date,
    reason text,
    date_from date,
    date_to date,
    previous_table text,
    date_transfered_to_hdpt date
);


ALTER TABLE public.supervisordb OWNER TO postgres;

--
-- Name: supervisory_plan_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE supervisory_plan_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.supervisory_plan_id_seq OWNER TO postgres;

--
-- Name: supervisory_plan; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE supervisory_plan (
    id integer DEFAULT nextval('supervisory_plan_id_seq'::regclass) NOT NULL,
    supervisorcode character varying(15) NOT NULL,
    designation character varying(50) NOT NULL,
    fmonth character varying(7) NOT NULL,
    session_type character varying(30) NOT NULL,
    site_name text,
    facode character varying(6),
    planned_date date NOT NULL,
    is_conducted character varying(1),
    remarks text,
    submitted_date date DEFAULT now() NOT NULL,
    updated_date date,
    area_name character varying(225),
    conduct_date date,
    conduct_remarks text,
    status integer DEFAULT 0,
    procode character varying(2),
    distcode character varying(3),
    uncode character varying(9),
    quarter character varying(2)
);


ALTER TABLE public.supervisory_plan OWNER TO postgres;

--
-- Name: week_vpd_type_cases_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE week_vpd_type_cases_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.week_vpd_type_cases_seq OWNER TO postgres;

--
-- Name: surveillance_cases_types; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE surveillance_cases_types (
    id integer DEFAULT nextval('week_vpd_type_cases_seq'::regclass) NOT NULL,
    type_case_name text NOT NULL,
    type_short_code text NOT NULL,
    pro integer DEFAULT 0,
    short_name text
);


ALTER TABLE public.surveillance_cases_types OWNER TO postgres;

--
-- Name: TABLE surveillance_cases_types; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE surveillance_cases_types IS 'Table for Type of Cases for Surveillance.';


--
-- Name: tbbt; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tbbt (
    const_col integer DEFAULT 0 NOT NULL,
    id integer,
    val text
);


ALTER TABLE public.tbbt OWNER TO postgres;

--
-- Name: technician_checkin_details; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE technician_checkin_details (
    recno numeric DEFAULT nextval('checkin_detail_seq'::regclass) NOT NULL,
    techniciancode character varying(9) NOT NULL,
    imei character varying(15),
    checkin_time timestamp without time zone,
    checkout_time timestamp without time zone,
    checkin_lat text,
    checkin_long text,
    checkout_lat text,
    checkout_long text,
    work_date date NOT NULL
);


ALTER TABLE public.technician_checkin_details OWNER TO postgres;

--
-- Name: technician_new_id_pop; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE technician_new_id_pop
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999
    CACHE 1;


ALTER TABLE public.technician_new_id_pop OWNER TO postgres;

--
-- Name: techniciandb; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE techniciandb (
    techniciancode character varying(9) NOT NULL,
    technicianname character varying(40) NOT NULL,
    husbandname character varying(40),
    fathername character varying(40),
    nic character varying(15),
    date_of_birth date,
    procode character varying(1) NOT NULL,
    distcode character varying(3) NOT NULL,
    facode character varying(6) NOT NULL,
    supervisorcode character varying(9),
    tcode character varying(8),
    uncode character varying(12),
    catch_area_pop integer,
    catch_area_name character varying(150),
    permanent_address character varying(120),
    present_address character varying(120),
    lastqualification character varying(30),
    passingyear integer,
    institutename character varying(120),
    date_joining date,
    place_of_joining character varying(50),
    date_termination date,
    status character varying(15),
    areatype character varying(15),
    basic_training_start_date date,
    basic_training_end_date date,
    id integer DEFAULT nextval('technician_id_seq'::regclass) NOT NULL,
    city character varying(30),
    phone character varying(20),
    marital_status character varying(15),
    designation character varying(50),
    bankaccountno character varying(30),
    payscale character varying(10),
    bid character varying(10),
    basicpay double precision,
    house_rent_allowance double precision,
    medical_allowance double precision,
    convence_allowance double precision,
    reason character varying(200),
    date_transfer date,
    date_died date,
    date_retired date,
    routine_epi_start_date date,
    routine_epi_end_date date,
    survilance_training_start_date date,
    survilance_training_end_date date,
    cold_chain_training_start_date date,
    cold_chain_training_end_date date,
    vlmis_training_start_date date,
    vlmis_training_end_date date,
    rec_training_end_date date,
    rec_training_start_date date,
    branchcode character varying(15),
    branchname character varying(50),
    employee_type character varying(50),
    iemi_no text,
    pin_no integer,
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    previouse_code character varying(9) DEFAULT NULL::character varying,
    date_resigned date,
    previous_table text,
    previous_code integer,
    date_from date,
    date_to date,
    newcode character varying(9),
    gender character varying(6)
);


ALTER TABLE public.techniciandb OWNER TO postgres;

--
-- Name: COLUMN techniciandb.is_temp_saved; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN techniciandb.is_temp_saved IS '0 means form is completely filled and saved from submit button, 1 means checklist is not completed and temporarily saved for re-edit later';


--
-- Name: techniciandb_pop; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE techniciandb_pop (
    id integer DEFAULT nextval('technician_new_id_pop'::regclass) NOT NULL,
    techniciancode character varying(9) NOT NULL,
    year character varying(4),
    population character varying(10),
    created_date date,
    update_date date,
    update_by text
);


ALTER TABLE public.techniciandb_pop OWNER TO postgres;

--
-- Name: tehsil_tid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tehsil_tid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999999
    CACHE 1;


ALTER TABLE public.tehsil_tid_seq OWNER TO postgres;

--
-- Name: tehsil; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tehsil (
    tid integer DEFAULT nextval('tehsil_tid_seq'::regclass) NOT NULL,
    tehsil character varying(100),
    distcode character varying(3),
    population character varying(10),
    procode character varying(2),
    tcode character varying(7),
    addedby integer DEFAULT 0,
    addeddate date,
    updateddate date,
    batch_status character varying(2) DEFAULT 0,
    sync_status character varying(2),
    update_status character varying(2),
    tsl_type character varying(2)
);


ALTER TABLE public.tehsil OWNER TO postgres;

--
-- Name: tehsil_population_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tehsil_population_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.tehsil_population_id_seq OWNER TO postgres;

--
-- Name: tehsil_population; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tehsil_population (
    id integer DEFAULT nextval('tehsil_population_id_seq'::regclass) NOT NULL,
    tcode character varying(6),
    year character varying(4),
    population integer,
    created_date date,
    update_date date,
    update_by text,
    distcode character varying
);


ALTER TABLE public.tehsil_population OWNER TO postgres;

--
-- Name: temp_adjustment_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE temp_adjustment_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999
    CACHE 1;


ALTER TABLE public.temp_adjustment_seq OWNER TO postgres;

--
-- Name: tempmoon; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tempmoon (
    pk_id integer,
    main_id integer,
    item_id integer,
    batch_number text,
    batch_doses integer,
    opening_doses integer,
    received_doses integer,
    used_doses integer,
    used_vials double precision,
    unused_doses integer,
    unused_vials double precision,
    closing_doses integer,
    closing_vials double precision,
    vaccinated integer
);


ALTER TABLE public.tempmoon OWNER TO postgres;

--
-- Name: testuc; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE testuc (
    unid character varying(15),
    uncode character varying(10) NOT NULL,
    un_name character varying(100),
    tcode character varying(6),
    distcode character varying(3),
    procode character varying(2),
    population character varying(10),
    areatype character varying(5) DEFAULT 'urban'::character varying,
    address text,
    areas text,
    geocoordinates text,
    svg text,
    highchart text
);


ALTER TABLE public.testuc OWNER TO postgres;

--
-- Name: tmptable; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tmptable (
    facode character varying(6),
    week character varying(2),
    aids_cases integer,
    aids_deaths integer,
    tf_cases integer,
    tf_deaths integer,
    avh_cases integer,
    avh_deaths integer,
    tmp_tf_cases integer,
    tmp_tf_deaths integer
);


ALTER TABLE public.tmptable OWNER TO postgres;

--
-- Name: training_types_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE training_types_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.training_types_id_seq OWNER TO postgres;

--
-- Name: training_types; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE training_types (
    id integer DEFAULT nextval('training_types_id_seq'::regclass) NOT NULL,
    name text NOT NULL,
    description text,
    start_date date NOT NULL,
    end_date date NOT NULL,
    venue text,
    is_active character varying(1) DEFAULT 0 NOT NULL,
    created_date timestamp without time zone,
    created_by character varying(50)
);


ALTER TABLE public.training_types OWNER TO postgres;

--
-- Name: COLUMN training_types.name; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN training_types.name IS 'basic training,epimis training, epimis refresher, soldchain training etc';


--
-- Name: COLUMN training_types.start_date; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN training_types.start_date IS 'when training started';


--
-- Name: COLUMN training_types.end_date; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN training_types.end_date IS 'when training ended';


--
-- Name: COLUMN training_types.is_active; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN training_types.is_active IS 'if type is applicable for logged in region/user or not.';


--
-- Name: COLUMN training_types.created_by; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN training_types.created_by IS 'user id';


--
-- Name: transac_log_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE transac_log_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999999999999
    CACHE 1;


ALTER TABLE public.transac_log_seq OWNER TO postgres;

--
-- Name: transport_questionnaire_cols_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE transport_questionnaire_cols_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.transport_questionnaire_cols_id_seq OWNER TO postgres;

--
-- Name: transport_questionnaire_cols; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE transport_questionnaire_cols (
    id integer DEFAULT nextval('transport_questionnaire_cols_id_seq'::regclass) NOT NULL,
    main_id integer,
    transport_type character varying(10),
    model character varying(100),
    make character varying(150),
    year_manufacture character varying(4),
    tot_number integer,
    not_working integer,
    reasons_not_working character varying(100),
    percentage_used double precision,
    fuel_type text
);


ALTER TABLE public.transport_questionnaire_cols OWNER TO postgres;

--
-- Name: transport_questionnaire_main_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE transport_questionnaire_main_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.transport_questionnaire_main_id_seq OWNER TO postgres;

--
-- Name: transport_questionnaire_main; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE transport_questionnaire_main (
    id integer DEFAULT nextval('transport_questionnaire_main_id_seq'::regclass) NOT NULL,
    procode character varying(1) DEFAULT 3,
    distcode character varying(3),
    tcode character varying(6),
    uncode character varying(9),
    facode character varying(6),
    comments text,
    pr_name character varying(150),
    pr_desg character varying(100),
    pr_mob character varying(30),
    pr_email character varying(50),
    cctl_name character varying(150),
    cctl_mob character varying(30),
    dc_name character varying(150),
    dc_desg character varying(100),
    dc_email character varying(50),
    dc_mob character varying(30),
    dc_date date,
    date_submitted date,
    cctl_desg text,
    cctl_email text,
    year character varying(4),
    quarter character varying(4),
    fquarter character varying(8)
);


ALTER TABLE public.transport_questionnaire_main OWNER TO postgres;

--
-- Name: uc_wise_maps_path_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE uc_wise_maps_path_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999999
    CACHE 1
    CYCLE;


ALTER TABLE public.uc_wise_maps_path_id OWNER TO postgres;

--
-- Name: uc_wise_maps_path_id_old; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE uc_wise_maps_path_id_old
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999999
    CACHE 1
    CYCLE;


ALTER TABLE public.uc_wise_maps_path_id_old OWNER TO postgres;

--
-- Name: uc_wise_maps_paths; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE uc_wise_maps_paths (
    id integer DEFAULT nextval('uc_wise_maps_path_id'::regclass) NOT NULL,
    procode character varying(1),
    distcode character varying(3),
    uncode character varying(9),
    ucname text,
    path text,
    geo_paths text
);


ALTER TABLE public.uc_wise_maps_paths OWNER TO postgres;

--
-- Name: uc_wise_maps_paths_bk; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE uc_wise_maps_paths_bk (
    id integer,
    procode character varying(1),
    distcode character varying(3),
    uncode character varying(9),
    ucname text,
    path text
);


ALTER TABLE public.uc_wise_maps_paths_bk OWNER TO postgres;

--
-- Name: uc_wise_maps_paths_old; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE uc_wise_maps_paths_old (
    id integer DEFAULT nextval('uc_wise_maps_path_id_old'::regclass) NOT NULL,
    procode character varying(1),
    distcode character varying(3),
    uncode character varying(9),
    ucname text,
    path text
);


ALTER TABLE public.uc_wise_maps_paths_old OWNER TO postgres;

--
-- Name: uname; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE uname (
    un_name character varying(100)
);


ALTER TABLE public.uname OWNER TO postgres;

--
-- Name: unid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE unid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.unid_seq OWNER TO postgres;

--
-- Name: unioncouncil; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE unioncouncil (
    unid character varying(15) NOT NULL,
    uncode character varying(10),
    un_name character varying(100),
    tcode character varying(6),
    distcode character varying(3),
    procode character varying(2),
    population character varying(10),
    addedby integer DEFAULT 0,
    addeddate date,
    updateddate date,
    batch_status character varying(2) DEFAULT 0,
    update_status character varying(2),
    sync_status character varying(2),
    uc_type character varying(2),
    highchart_coordinates text
);


ALTER TABLE public.unioncouncil OWNER TO postgres;

--
-- Name: unioncouncil_old; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE unioncouncil_old (
    unid character varying(15) NOT NULL,
    uncode character varying(10),
    un_name character varying(100),
    tcode character varying(6),
    distcode character varying(3),
    procode character varying(2),
    population character varying(10),
    addedby integer DEFAULT 0,
    addeddate date,
    updateddate date,
    batch_status character varying(2) DEFAULT 0,
    update_status character varying(2),
    sync_status character varying(2)
);


ALTER TABLE public.unioncouncil_old OWNER TO postgres;

--
-- Name: unioncouncil_population_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE unioncouncil_population_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.unioncouncil_population_id_seq OWNER TO postgres;

--
-- Name: unioncouncil_population; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE unioncouncil_population (
    id integer DEFAULT nextval('unioncouncil_population_id_seq'::regclass) NOT NULL,
    uncode character varying(9),
    year character varying(4),
    population integer,
    created_date date,
    update_date date,
    update_by text,
    tcode character varying(6),
    distcode character varying(3)
);


ALTER TABLE public.unioncouncil_population OWNER TO postgres;

--
-- Name: user_level_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE user_level_seq
    START WITH 7
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999999999999
    CACHE 1
    CYCLE;


ALTER TABLE public.user_level_seq OWNER TO postgres;

--
-- Name: user_level_db; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE user_level_db (
    id integer DEFAULT nextval('user_level_seq'::regclass) NOT NULL,
    userlevel integer NOT NULL,
    userlevel_description text,
    flag integer DEFAULT 1 NOT NULL
);


ALTER TABLE public.user_level_db OWNER TO postgres;

--
-- Name: user_roles_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE user_roles_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999
    CACHE 1;


ALTER TABLE public.user_roles_seq OWNER TO postgres;

--
-- Name: user_roles; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE user_roles (
    id integer DEFAULT nextval('user_roles_seq'::regclass) NOT NULL,
    type integer NOT NULL,
    level integer NOT NULL,
    active integer NOT NULL
);


ALTER TABLE public.user_roles OWNER TO postgres;

--
-- Name: user_transaction_log; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE user_transaction_log (
    log_id integer DEFAULT nextval('transac_log_seq'::regclass) NOT NULL,
    username character varying(1000) NOT NULL,
    ip_address character varying(500) NOT NULL,
    browser character varying(1000) NOT NULL,
    module character varying(100) NOT NULL,
    action character varying(500) NOT NULL,
    primary_key character varying(2000),
    userlevel character varying(2),
    usertype character varying(25),
    datetime timestamp(6) without time zone
);


ALTER TABLE public.user_transaction_log OWNER TO postgres;

--
-- Name: user_types_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE user_types_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999999999999
    CACHE 1
    CYCLE;


ALTER TABLE public.user_types_seq OWNER TO postgres;

--
-- Name: user_types_db; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE user_types_db (
    id integer DEFAULT nextval('user_types_seq'::regclass) NOT NULL,
    usertype text,
    usertype_description text
);


ALTER TABLE public.user_types_db OWNER TO postgres;

--
-- Name: vacc_ccbi_cols_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE vacc_ccbi_cols_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999999999999999
    CACHE 1;


ALTER TABLE public.vacc_ccbi_cols_id_seq OWNER TO postgres;

--
-- Name: vacc_carriers_cols; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE vacc_carriers_cols (
    id integer DEFAULT nextval('vacc_ccbi_cols_id_seq'::regclass) NOT NULL,
    main_id integer DEFAULT 2,
    catalogue_id integer,
    cb_vc character varying(50),
    tot_vacc character varying(50),
    quntt_working character varying(50),
    quntt_not_working character varying(50),
    dimension_length character varying(50),
    dimension_width character varying(50),
    dimension_height character varying(50),
    eq_code_r1_f1 character varying(50),
    eq_code_r1_f2 character varying(50),
    eq_code_r1_f3 character varying(50),
    eq_code_r1_f4 character varying(50),
    eq_code_r1_f5 character varying(50)
);


ALTER TABLE public.vacc_carriers_cols OWNER TO postgres;

--
-- Name: vacc_carriers_cols_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE vacc_carriers_cols_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.vacc_carriers_cols_id_seq OWNER TO postgres;

--
-- Name: vacc_carriers_main_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE vacc_carriers_main_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.vacc_carriers_main_id_seq OWNER TO postgres;

--
-- Name: vacc_carriers_main; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE vacc_carriers_main (
    id integer DEFAULT nextval('vacc_carriers_main_id_seq'::regclass) NOT NULL,
    procode character varying(1) DEFAULT 2 NOT NULL,
    distcode character varying(3) NOT NULL,
    tcode character varying(6),
    uncode character varying(9),
    facode character varying(6) NOT NULL,
    ii_r1_f1 double precision,
    ii_r1_f2 double precision,
    ii_r1_f3 double precision,
    ii_r1_f4 double precision,
    ii_r1_f5 double precision,
    ii_r1_f6 double precision,
    ii_r1_f7 double precision,
    ii_r1_f8 double precision,
    ii_r1_f9 double precision,
    ii_r1_f10 double precision,
    ii_r1_f11 double precision,
    ii_r2_f1 integer,
    ii_r2_f2 integer,
    ii_r2_f3 integer,
    ii_r2_f4 integer,
    ii_r2_f5 integer,
    ii_r2_f6 integer,
    ii_r2_f7 integer,
    ii_r2_f8 integer,
    ii_r2_f9 integer,
    ii_r2_f10 integer,
    ii_r2_f11 integer,
    pr_name character varying(150),
    pr_desg character varying(100),
    pr_mob character varying(50),
    pr_email character varying(30),
    cc_name character varying(150),
    cc_mob character varying(100),
    date_submitted date,
    year character varying(4),
    quarter character varying(4),
    fquarter character varying(8)
);


ALTER TABLE public.vacc_carriers_main OWNER TO postgres;

--
-- Name: vacc_ccbi_main_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE vacc_ccbi_main_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999999999999999
    CACHE 1;


ALTER TABLE public.vacc_ccbi_main_id_seq OWNER TO postgres;

--
-- Name: vacc_ri_mr_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE vacc_ri_mr_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999999
    CACHE 1;


ALTER TABLE public.vacc_ri_mr_id_seq OWNER TO postgres;

--
-- Name: vacc_ri_mr; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE vacc_ri_mr (
    id integer DEFAULT nextval('vacc_ri_mr_id_seq'::regclass) NOT NULL,
    procode character varying(1) DEFAULT 3 NOT NULL,
    distcode character varying(3) NOT NULL,
    facode character varying(6) NOT NULL,
    tcode character varying(8) NOT NULL,
    fmonth character varying(8) NOT NULL,
    uncode character varying(9) NOT NULL,
    uc_tot_pop integer DEFAULT 0,
    uc_annual_pop_less_1year integer DEFAULT 0,
    uc_monthly_pop_less_1year integer DEFAULT 0,
    uc_annual_target_pop_women integer DEFAULT 0,
    uc_monthly_target_pop_women integer DEFAULT 0,
    vaccinators_names text,
    ri_r1_f1 integer DEFAULT 0,
    ri_r1_f2 date,
    ri_r1_f3 integer DEFAULT 0,
    ri_r1_f4 text DEFAULT 0,
    ri_r1_f5 date,
    ri_r1_f6 integer DEFAULT 0,
    ri_r1_f7 integer DEFAULT 0,
    ri_r1_f8 date,
    ri_r1_f9 text,
    ri_r2_f1 integer DEFAULT 0,
    ri_r2_f2 date,
    ri_r2_f3 integer DEFAULT 0,
    ri_r2_f4 text,
    ri_r2_f5 date,
    ri_r2_f6 integer DEFAULT 0,
    ri_r2_f7 integer DEFAULT 0,
    ri_r2_f8 date,
    ri_r2_f9 text,
    ri_r3_f1 integer DEFAULT 0,
    ri_r3_f2 date,
    ri_r3_f3 integer DEFAULT 0,
    ri_r3_f4 text,
    ri_r3_f5 date,
    ri_r3_f6 integer DEFAULT 0,
    ri_r3_f7 integer DEFAULT 0,
    ri_r3_f8 date,
    ri_r3_f9 text,
    ri_r4_f1 integer DEFAULT 0,
    ri_r4_f2 date,
    ri_r4_f3 integer DEFAULT 0,
    ri_r4_f4 text,
    ri_r4_f5 date,
    ri_r4_f6 integer DEFAULT 0,
    ri_r4_f7 integer DEFAULT 0,
    ri_r4_f8 date,
    ri_r4_f9 text,
    ri_r5_f1 integer DEFAULT 0,
    ri_r5_f2 date,
    ri_r5_f3 integer DEFAULT 0,
    ri_r5_f4 text,
    ri_r5_f5 date,
    ri_r5_f6 integer DEFAULT 0,
    ri_r5_f7 integer DEFAULT 0,
    ri_r5_f8 date,
    ri_r5_f9 text,
    ri_r6_f1 integer DEFAULT 0,
    ri_r6_f2 date,
    ri_r6_f3 integer DEFAULT 0,
    ri_r6_f4 text,
    ri_r6_f5 date,
    ri_r6_f6 integer DEFAULT 0,
    ri_r6_f7 integer DEFAULT 0,
    ri_r6_f8 date,
    ri_r6_f9 text,
    ri_r7_f1 integer DEFAULT 0,
    ri_r7_f2 date,
    ri_r7_f3 integer DEFAULT 0,
    ri_r7_f4 text,
    ri_r7_f5 date,
    ri_r7_f6 integer DEFAULT 0,
    ri_r7_f7 integer DEFAULT 0,
    ri_r7_f8 date,
    ri_r7_f9 text,
    ri_r8_f1 integer DEFAULT 0,
    ri_r8_f2 date,
    ri_r8_f3 integer DEFAULT 0,
    ri_r8_f4 text,
    ri_r8_f5 date,
    ri_r8_f6 integer DEFAULT 0,
    ri_r8_f7 integer DEFAULT 0,
    ri_r8_f8 date,
    ri_r8_f9 text,
    ri_r9_f1 integer DEFAULT 0,
    ri_r9_f2 date,
    ri_r9_f3 integer DEFAULT 0,
    ri_r9_f4 text,
    ri_r9_f5 date,
    ri_r9_f6 integer DEFAULT 0,
    ri_r9_f7 integer DEFAULT 0,
    ri_r9_f8 date,
    ri_r9_f9 text,
    ri_r10_f1 integer DEFAULT 0,
    ri_r10_f2 date,
    ri_r10_f3 integer DEFAULT 0,
    ri_r10_f4 text,
    ri_r10_f5 date,
    ri_r10_f6 integer DEFAULT 0,
    ri_r10_f7 integer DEFAULT 0,
    ri_r10_f8 date,
    ri_r10_f9 text,
    ri_r11_f1 integer DEFAULT 0,
    ri_r11_f2 date,
    ri_r11_f3 integer DEFAULT 0,
    ri_r11_f4 text,
    ri_r11_f5 date,
    ri_r11_f6 integer DEFAULT 0,
    ri_r11_f7 integer DEFAULT 0,
    ri_r11_f8 date,
    ri_r11_f9 text,
    ri_r12_f1 integer DEFAULT 0,
    ri_r12_f2 date,
    ri_r12_f3 integer DEFAULT 0,
    ri_r12_f4 text,
    ri_r12_f5 date,
    ri_r12_f6 integer DEFAULT 0,
    ri_r12_f7 integer DEFAULT 0,
    ri_r12_f8 date,
    ri_r12_f9 text,
    ri_r13_f1 integer DEFAULT 0,
    ri_r13_f2 date,
    ri_r13_f3 integer DEFAULT 0,
    ri_r13_f4 text,
    ri_r13_f5 date,
    ri_r13_f6 integer DEFAULT 0,
    ri_r13_f7 integer DEFAULT 0,
    ri_r13_f8 date,
    ri_r13_f9 text,
    ri_r14_f1 integer DEFAULT 0,
    ri_r14_f2 date,
    ri_r14_f3 integer DEFAULT 0,
    ri_r14_f4 text,
    ri_r14_f5 date,
    ri_r14_f6 integer DEFAULT 0,
    ri_r14_f7 integer DEFAULT 0,
    ri_r14_f8 date,
    ri_r14_f9 text,
    ri_r15_f1 integer DEFAULT 0,
    ri_r15_f2 date,
    ri_r15_f3 integer DEFAULT 0,
    ri_r15_f4 text,
    ri_r15_f5 date,
    ri_r15_f6 integer DEFAULT 0,
    ri_r15_f7 integer DEFAULT 0,
    ri_r15_f8 date,
    ri_r15_f9 text,
    ri_r16_f1 integer DEFAULT 0,
    ri_r16_f2 date,
    ri_r16_f3 integer DEFAULT 0,
    ri_r16_f4 text,
    ri_r16_f5 date,
    ri_r16_f6 integer DEFAULT 0,
    ri_r16_f7 integer DEFAULT 0,
    ri_r16_f8 date,
    ri_r16_f9 text,
    ri_r17_f1 integer DEFAULT 0,
    ri_r17_f2 date,
    ri_r17_f3 integer DEFAULT 0,
    ri_r17_f4 text,
    ri_r17_f5 date,
    ri_r17_f6 integer DEFAULT 0,
    ri_r17_f7 integer DEFAULT 0,
    ri_r17_f8 date,
    ri_r17_f9 text,
    ri_r18_f1 integer DEFAULT 0,
    ri_r18_f2 date,
    ri_r18_f3 integer DEFAULT 0,
    ri_r18_f4 text,
    ri_r18_f5 date,
    ri_r18_f6 integer DEFAULT 0,
    ri_r18_f7 integer DEFAULT 0,
    ri_r18_f8 date,
    ri_r18_f9 text,
    ri_r19_f1 integer DEFAULT 0,
    ri_r19_f2 date,
    ri_r19_f3 integer DEFAULT 0,
    ri_r19_f4 text,
    ri_r19_f5 date,
    ri_r19_f6 integer DEFAULT 0,
    ri_r19_f7 integer DEFAULT 0,
    ri_r19_f8 date,
    ri_r19_f9 text,
    ri_r20_f1 integer DEFAULT 0,
    ri_r20_f2 date,
    ri_r20_f3 integer DEFAULT 0,
    ri_r20_f4 text,
    ri_r20_f5 date,
    ri_r20_f6 integer DEFAULT 0,
    ri_r20_f7 integer DEFAULT 0,
    ri_r20_f8 date,
    ri_r20_f9 text,
    ri_r21_f1 integer DEFAULT 0,
    ri_r21_f2 date,
    ri_r21_f3 integer DEFAULT 0,
    ri_r21_f4 text,
    ri_r21_f5 date,
    ri_r21_f6 integer DEFAULT 0,
    ri_r21_f7 integer DEFAULT 0,
    ri_r21_f8 date,
    ri_r21_f9 text,
    ri_r22_f1 integer DEFAULT 0,
    ri_r22_f2 date,
    ri_r22_f3 integer DEFAULT 0,
    ri_r22_f4 text,
    ri_r22_f5 date,
    ri_r22_f6 integer DEFAULT 0,
    ri_r22_f7 integer DEFAULT 0,
    ri_r22_f8 date,
    ri_r22_f9 text,
    ri_r23_f1 integer DEFAULT 0,
    ri_r23_f2 date,
    ri_r23_f3 integer DEFAULT 0,
    ri_r23_f4 text,
    ri_r23_f5 date,
    ri_r23_f6 integer DEFAULT 0,
    ri_r23_f7 integer DEFAULT 0,
    ri_r23_f8 date,
    ri_r23_f9 text,
    ri_r24_f1 integer DEFAULT 0,
    ri_r24_f2 date,
    ri_r24_f3 integer DEFAULT 0,
    ri_r24_f4 text,
    ri_r24_f5 date,
    ri_r24_f6 integer DEFAULT 0,
    ri_r24_f7 integer DEFAULT 0,
    ri_r24_f8 date,
    ri_r24_f9 text,
    ri_r25_f1 integer DEFAULT 0,
    ri_r25_f2 date,
    ri_r25_f3 integer DEFAULT 0,
    ri_r25_f4 text,
    ri_r25_f5 date,
    ri_r25_f6 integer DEFAULT 0,
    ri_r25_f7 integer DEFAULT 0,
    ri_r25_f8 date,
    ri_r25_f9 text,
    ri_r26_f1 integer DEFAULT 0,
    ri_r26_f2 date,
    ri_r26_f3 integer DEFAULT 0,
    ri_r26_f4 text,
    ri_r26_f5 date,
    ri_r26_f6 integer DEFAULT 0,
    ri_r26_f7 integer DEFAULT 0,
    ri_r26_f8 date,
    ri_r26_f9 text,
    ri_r27_f1 integer DEFAULT 0,
    ri_r27_f2 date,
    ri_r27_f3 integer DEFAULT 0,
    ri_r27_f4 text,
    ri_r27_f5 date,
    ri_r27_f6 integer DEFAULT 0,
    ri_r27_f7 integer DEFAULT 0,
    ri_r27_f8 date,
    ri_r27_f9 text,
    ri_r28_f1 integer DEFAULT 0,
    ri_r28_f2 date,
    ri_r28_f3 integer DEFAULT 0,
    ri_r28_f4 text,
    ri_r28_f5 date,
    ri_r28_f6 integer DEFAULT 0,
    ri_r28_f7 integer DEFAULT 0,
    ri_r28_f8 date,
    ri_r28_f9 text,
    ri_r29_f1 integer DEFAULT 0,
    ri_r29_f2 date,
    ri_r29_f3 integer DEFAULT 0,
    ri_r29_f4 text,
    ri_r29_f5 date,
    ri_r29_f6 integer DEFAULT 0,
    ri_r29_f7 integer DEFAULT 0,
    ri_r29_f8 date,
    ri_r29_f9 text,
    ri_r30_f1 integer DEFAULT 0,
    ri_r30_f2 date,
    ri_r30_f3 integer DEFAULT 0,
    ri_r30_f4 text,
    ri_r30_f5 date,
    ri_r30_f6 integer DEFAULT 0,
    ri_r30_f7 integer DEFAULT 0,
    ri_r30_f8 date,
    ri_r30_f9 text,
    ri_r31_f1 integer DEFAULT 0,
    ri_r31_f2 date,
    ri_r31_f3 integer DEFAULT 0,
    ri_r31_f4 text,
    ri_r31_f5 date,
    ri_r31_f6 integer DEFAULT 0,
    ri_r31_f7 integer DEFAULT 0,
    ri_r31_f8 date,
    ri_r31_f9 text,
    ri_r32_f1 integer DEFAULT 0,
    ri_r32_f2 date,
    ri_r32_f3 integer DEFAULT 0,
    ri_r32_f4 text,
    ri_r32_f5 date,
    ri_r32_f6 integer DEFAULT 0,
    ri_r32_f7 integer DEFAULT 0,
    ri_r32_f8 date,
    ri_r32_f9 text,
    ri_r33_f1 integer DEFAULT 0,
    ri_r33_f2 date,
    ri_r33_f3 integer DEFAULT 0,
    ri_r33_f4 text,
    ri_r33_f5 date,
    ri_r33_f6 integer DEFAULT 0,
    ri_r33_f7 integer DEFAULT 0,
    ri_r33_f8 date,
    ri_r33_f9 text,
    ri_r34_f1 integer DEFAULT 0,
    ri_r34_f2 date,
    ri_r34_f3 integer DEFAULT 0,
    ri_r34_f4 text,
    ri_r34_f5 date,
    ri_r34_f6 integer DEFAULT 0,
    ri_r34_f7 integer DEFAULT 0,
    ri_r34_f8 date,
    ri_r34_f9 text,
    ri_r35_f1 integer DEFAULT 0,
    ri_r35_f2 date,
    ri_r35_f3 integer DEFAULT 0,
    ri_r35_f4 text,
    ri_r35_f5 date,
    ri_r35_f6 integer DEFAULT 0,
    ri_r35_f7 integer DEFAULT 0,
    ri_r35_f8 date,
    ri_r35_f9 text,
    ri_r36_f1 integer DEFAULT 0,
    ri_r36_f2 date,
    ri_r36_f3 integer DEFAULT 0,
    ri_r36_f4 text,
    ri_r36_f5 date,
    ri_r36_f6 integer DEFAULT 0,
    ri_r36_f7 integer DEFAULT 0,
    ri_r36_f8 date,
    ri_r36_f9 text,
    ri_r37_f1 integer DEFAULT 0,
    ri_r37_f2 date,
    ri_r37_f3 integer DEFAULT 0,
    ri_r37_f4 text,
    ri_r37_f5 date,
    ri_r37_f6 integer DEFAULT 0,
    ri_r37_f7 integer DEFAULT 0,
    ri_r37_f8 date,
    ri_r37_f9 text,
    ri_r38_f1 integer DEFAULT 0,
    ri_r38_f2 date,
    ri_r38_f3 integer DEFAULT 0,
    ri_r38_f4 text,
    ri_r38_f5 date,
    ri_r38_f6 integer DEFAULT 0,
    ri_r38_f7 integer DEFAULT 0,
    ri_r38_f8 date,
    ri_r38_f9 text,
    ri_r39_f1 integer DEFAULT 0,
    ri_r39_f2 date,
    ri_r39_f3 integer DEFAULT 0,
    ri_r39_f4 text,
    ri_r39_f5 date,
    ri_r39_f6 integer DEFAULT 0,
    ri_r39_f7 integer DEFAULT 0,
    ri_r39_f8 date,
    ri_r39_f9 text,
    ri_r40_f1 integer DEFAULT 0,
    ri_r40_f2 date,
    ri_r40_f3 integer DEFAULT 0,
    ri_r40_f4 text,
    ri_r40_f5 date,
    ri_r40_f6 integer DEFAULT 0,
    ri_r40_f7 integer DEFAULT 0,
    ri_r40_f8 date,
    ri_r40_f9 text,
    vacc_name text,
    date date
);


ALTER TABLE public.vacc_ri_mr OWNER TO postgres;

--
-- Name: vaccinationcompliance_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE vaccinationcompliance_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.vaccinationcompliance_id_seq OWNER TO postgres;

--
-- Name: vaccinationcompliance; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE vaccinationcompliance (
    id integer DEFAULT nextval('vaccinationcompliance_id_seq'::regclass) NOT NULL,
    duem1 integer DEFAULT 0,
    duem2 integer DEFAULT 0,
    duem3 integer DEFAULT 0,
    duem4 integer DEFAULT 0,
    duem5 integer DEFAULT 0,
    duem6 integer DEFAULT 0,
    duem7 integer DEFAULT 0,
    duem8 integer DEFAULT 0,
    duem9 integer DEFAULT 0,
    duem10 integer DEFAULT 0,
    duem11 integer DEFAULT 0,
    duem12 integer DEFAULT 0,
    subm1 integer DEFAULT 0,
    subm2 integer DEFAULT 0,
    subm3 integer DEFAULT 0,
    subm4 integer DEFAULT 0,
    subm5 integer DEFAULT 0,
    subm6 integer DEFAULT 0,
    subm7 integer DEFAULT 0,
    subm8 integer DEFAULT 0,
    subm9 integer DEFAULT 0,
    subm10 integer DEFAULT 0,
    subm11 integer DEFAULT 0,
    subm12 integer DEFAULT 0,
    year character varying(4) DEFAULT 0,
    distcode character varying(3) DEFAULT 0,
    procode character varying(1) DEFAULT 3 NOT NULL,
    tsubm1 integer DEFAULT 0,
    tsubm2 integer DEFAULT 0,
    tsubm3 integer DEFAULT 0,
    tsubm4 integer DEFAULT 0,
    tsubm5 integer DEFAULT 0,
    tsubm6 integer DEFAULT 0,
    tsubm7 integer DEFAULT 0,
    tsubm8 integer DEFAULT 0,
    tsubm9 integer DEFAULT 0,
    tsubm10 integer DEFAULT 0,
    tsubm11 integer DEFAULT 0,
    tsubm12 integer DEFAULT 0,
    flag integer DEFAULT 0
);


ALTER TABLE public.vaccinationcompliance OWNER TO postgres;

--
-- Name: vaccine_titles; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE vaccine_titles (
    vacc_id integer,
    vacc_name character varying(50)
);


ALTER TABLE public.vaccine_titles OWNER TO postgres;

--
-- Name: vaccine_vials_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE vaccine_vials_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999999
    CACHE 1;


ALTER TABLE public.vaccine_vials_seq OWNER TO postgres;

--
-- Name: vaccine_vials_daily_record; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE vaccine_vials_daily_record (
    pk_id integer DEFAULT nextval('vaccine_vials_seq'::regclass) NOT NULL,
    techniciancode character varying(9),
    date date,
    batch_number text DEFAULT 'BB2019'::text,
    facode character varying(6),
    fmonth character varying(7),
    created_date timestamp without time zone,
    used_vials double precision,
    used_doses integer,
    unused_vials double precision,
    unused_doses integer,
    item_id integer,
    vaccinated integer
);


ALTER TABLE public.vaccine_vials_daily_record OWNER TO postgres;

--
-- Name: village_merger_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE village_merger_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999
    CACHE 1
    CYCLE;


ALTER TABLE public.village_merger_seq OWNER TO postgres;

--
-- Name: village_merger; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE village_merger (
    pk_id integer DEFAULT nextval('village_merger_seq'::regclass) NOT NULL,
    mergername text NOT NULL,
    totalpopulation bigint NOT NULL,
    procode character varying(1) DEFAULT 3 NOT NULL,
    distcode character varying(3) NOT NULL,
    tcode character varying(6) NOT NULL,
    uncode character varying(9) NOT NULL,
    year character varying(4) NOT NULL,
    merger_group_id integer,
    facode character(6)
);


ALTER TABLE public.village_merger OWNER TO postgres;

--
-- Name: TABLE village_merger; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE village_merger IS 'This table will be used for microplan villages merger';


--
-- Name: villages; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE villages (
    id integer DEFAULT nextval('epi_village_id_seq'::regclass) NOT NULL,
    procode character varying(1) NOT NULL,
    distcode character varying(3) NOT NULL,
    tcode character varying(6) NOT NULL,
    uncode character varying(9) NOT NULL,
    vcode character varying(12) NOT NULL,
    village text NOT NULL,
    population character varying(6),
    updated_date date,
    added_date date NOT NULL,
    imei character varying(15),
    postal_address text,
    population_less_year character varying(6),
    year character varying(4),
    facode character varying(6)
);


ALTER TABLE public.villages OWNER TO postgres;

--
-- Name: villages_population_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE villages_population_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999
    CACHE 1;


ALTER TABLE public.villages_population_id_seq OWNER TO postgres;

--
-- Name: villages_population; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE villages_population (
    id integer DEFAULT nextval('villages_population_id_seq'::regclass) NOT NULL,
    vcode character varying(12),
    year character varying(4),
    population character varying DEFAULT 0,
    created_date date DEFAULT now(),
    update_date date,
    update_by text,
    distcode character varying(3),
    uncode character varying(9),
    procode character varying(1),
    facode character varying,
    merged_village integer DEFAULT 0 NOT NULL,
    merger_group_id integer,
    tcode character varying(6)
);


ALTER TABLE public.villages_population OWNER TO postgres;

--
-- Name: vpd_diseases; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE vpd_diseases (
    id integer NOT NULL,
    name text
);


ALTER TABLE public.vpd_diseases OWNER TO postgres;

--
-- Name: vpdcases_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE vpdcases_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999999999999
    CACHE 1;


ALTER TABLE public.vpdcases_id_seq OWNER TO postgres;

--
-- Name: vpdsur_recid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE vpdsur_recid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 9999999999
    CACHE 1;


ALTER TABLE public.vpdsur_recid_seq OWNER TO postgres;

--
-- Name: vvm_stage_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE vvm_stage_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999
    CACHE 1;


ALTER TABLE public.vvm_stage_seq OWNER TO postgres;

--
-- Name: vvm_stages; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE vvm_stages (
    id integer DEFAULT nextval('vvm_stage_seq'::regclass) NOT NULL,
    type integer,
    name text,
    value text
);


ALTER TABLE public.vvm_stages OWNER TO postgres;

--
-- Name: vvm_type_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE vvm_type_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 99999
    CACHE 1;


ALTER TABLE public.vvm_type_seq OWNER TO postgres;

--
-- Name: vvm_types; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE vvm_types (
    id integer DEFAULT nextval('vvm_type_seq'::regclass) NOT NULL,
    type character varying(50)
);


ALTER TABLE public.vvm_types OWNER TO postgres;

--
-- Name: warehouse_type_categories_pkid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE warehouse_type_categories_pkid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2739999999
    CACHE 1;


ALTER TABLE public.warehouse_type_categories_pkid_seq OWNER TO postgres;

--
-- Name: warehouse_types_pkid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE warehouse_types_pkid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2739999999
    CACHE 1;


ALTER TABLE public.warehouse_types_pkid_seq OWNER TO postgres;

--
-- Name: warehouses_pkid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE warehouses_pkid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 2739999999
    CACHE 1;


ALTER TABLE public.warehouses_pkid_seq OWNER TO postgres;

--
-- Name: weekly_vpd; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE weekly_vpd (
    recid integer DEFAULT nextval('vpdsur_recid_seq'::regclass) NOT NULL,
    distcode character varying(3) NOT NULL,
    tcode character varying(6) NOT NULL,
    uncode character varying(9),
    facode character varying(6),
    year character varying(4) NOT NULL,
    week integer NOT NULL,
    datefrom date,
    dateto date,
    name_case text,
    gender text,
    case_father_name text,
    case_father_nic character varying(15),
    case_cell character varying(20),
    case_address text,
    case_type text,
    epid_no text,
    case_date_onset date,
    case_date_investigation date,
    case_date_last_dose_received date,
    case_date_specieman date,
    specieman_result text,
    case_date_follow date,
    complication_follow text,
    death_follow text,
    death_date_follow date,
    prepared_by text,
    prepared_by_designation text,
    facility_incharge text,
    facility_incharge_designation text,
    submitted_date date,
    fweek character varying(7),
    procode character varying(1),
    case_type_speceicman text,
    case_uncode character varying(9),
    epid_number integer,
    dist_shortcode character varying(3),
    case_shortcode text,
    case_distcode character varying(3),
    case_tcode character varying(6),
    case_representation integer,
    other_case_representation text,
    complication_type text,
    case_reported integer DEFAULT 1 NOT NULL,
    editted_date date,
    age_months integer DEFAULT 0,
    outcomes character varying(50),
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    doses_received text,
    cityname character varying(30),
    dateofresult date,
    ontime character varying(3),
    remarks text,
    cross_notified integer DEFAULT 0,
    approval_status character varying(10),
    cross_notified_from_distcode character varying(3),
    rb_distcode character varying(3),
    rb_tcode character varying(6),
    rb_uncode character varying(9),
    rb_facode character varying(6),
    rb_faddress text
);


ALTER TABLE public.weekly_vpd OWNER TO postgres;

--
-- Name: COLUMN weekly_vpd.is_temp_saved; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN weekly_vpd.is_temp_saved IS '0 means form is completely filled and saved from submit button, 1 means checklist is not completed and temporarily saved for re-edit later';


--
-- Name: weekly_vpd old; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "weekly_vpd old" (
    recid integer NOT NULL,
    facode character varying(6),
    distcode character varying(3),
    year character varying(4),
    epi_week integer DEFAULT 0,
    fweek character varying(7),
    date_from date,
    date_to date,
    tcode character varying(6),
    uncode character varying(9),
    procode character varying(1),
    aefi integer DEFAULT 0,
    afp integer DEFAULT 0,
    nt integer DEFAULT 0,
    childhood_tb integer DEFAULT 0,
    diphtheria integer DEFAULT 0,
    pertussis integer DEFAULT 0,
    measles integer DEFAULT 0,
    prepared_by character varying(100),
    prepared_by_designation character varying(100),
    facility_incharge character varying(100),
    facility_incharge_designation character varying(100),
    submitted_date date,
    received_in_edo_off date
);


ALTER TABLE public."weekly_vpd old" OWNER TO postgres;

--
-- Name: weekly_vpd_cases; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE weekly_vpd_cases (
    case_type character varying(100),
    case_name character varying(100),
    case_father_name character varying(100),
    case_address character varying(100),
    case_age character varying(100),
    case_sex character varying(100),
    case_date_onset date,
    case_tot_vacc_received integer DEFAULT 0,
    case_last_dose_received date,
    case_presentation character varying(100),
    facode character varying(6),
    distcode character varying(3),
    fweek character varying(10),
    vpd_id integer NOT NULL,
    id integer DEFAULT nextval('vpdcases_id_seq'::regclass) NOT NULL,
    procode character varying(1) DEFAULT 3
);


ALTER TABLE public.weekly_vpd_cases OWNER TO postgres;

--
-- Name: weekly_vpd_idsrs; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE weekly_vpd_idsrs (
    recid integer DEFAULT nextval('idsrs_wvpd_recid_seq'::regclass) NOT NULL,
    distcode character varying(3),
    tcode character varying(6),
    uncode character varying(9),
    facode character varying(6),
    year character varying(7),
    epi_week integer,
    date_from date,
    date_to date,
    name_case text,
    gender text,
    case_age text,
    case_father_name text,
    case_father_nic character varying(15),
    case_cell character varying(20),
    case_address text,
    case_type text,
    case_aefi character varying(5),
    epid_no text,
    case_date_onset date,
    case_date_investigation date,
    case_tot_vacc_received text,
    case_date_last_dose_received date,
    case_date_specieman date,
    specieman_result text,
    case_representation text,
    case_date_follow date,
    complication_follow text,
    complication_date date,
    death_follow text,
    death_date_follow date,
    fweek character varying(7),
    procode character varying(1),
    case_type_speceicman text,
    case_uncode character varying(9),
    epid_number integer
);


ALTER TABLE public.weekly_vpd_idsrs OWNER TO postgres;

--
-- Name: widget_filters_seqid; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE widget_filters_seqid
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.widget_filters_seqid OWNER TO postgres;

--
-- Name: widget_filters; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE widget_filters (
    pk_id integer DEFAULT nextval('widget_filters_seqid'::regclass) NOT NULL,
    dashboard_widget_id integer NOT NULL,
    custom_filter_detail_id integer,
    main_filter_id integer NOT NULL,
    filter_select_value text
);


ALTER TABLE public.widget_filters OWNER TO postgres;

--
-- Name: TABLE widget_filters; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE widget_filters IS 'When a widget in a dashboard will be saved then its selected filters will be save here with widget id';


--
-- Name: widget_indicators; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE widget_indicators (
    pk_id integer NOT NULL,
    widget_id integer NOT NULL,
    indicator_id integer NOT NULL
);


ALTER TABLE public.widget_indicators OWNER TO postgres;

--
-- Name: TABLE widget_indicators; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE widget_indicators IS 'Gerund table for indicators and its linked widgets';


--
-- Name: widget_indicators_indicator_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE widget_indicators_indicator_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.widget_indicators_indicator_id_seq OWNER TO postgres;

--
-- Name: widget_indicators_indicator_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE widget_indicators_indicator_id_seq OWNED BY widget_indicators.indicator_id;


--
-- Name: widget_indicators_widget_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE widget_indicators_widget_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.widget_indicators_widget_id_seq OWNER TO postgres;

--
-- Name: widget_indicators_widget_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE widget_indicators_widget_id_seq OWNED BY widget_indicators.widget_id;


--
-- Name: widget_queries_seq_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE widget_queries_seq_id
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.widget_queries_seq_id OWNER TO postgres;

--
-- Name: widget_quries; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE widget_quries (
    pk_id integer DEFAULT nextval('widget_queries_seq_id'::regclass) NOT NULL,
    dashboard_id integer NOT NULL,
    widget_id integer NOT NULL,
    widget_query text NOT NULL,
    last_update timestamp without time zone DEFAULT now() NOT NULL,
    multiseries integer DEFAULT 0,
    noofseries integer DEFAULT 1,
    "order" character varying(15)
);


ALTER TABLE public.widget_quries OWNER TO postgres;

--
-- Name: TABLE widget_quries; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE widget_quries IS 'all dashboards widgets queries will be stored here';


--
-- Name: widget_type; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE widget_type (
    pk_id integer NOT NULL,
    name character varying(50) NOT NULL,
    active integer DEFAULT 1 NOT NULL,
    "order" integer NOT NULL,
    class character varying(100),
    hc_type character varying(50)
);


ALTER TABLE public.widget_type OWNER TO postgres;

--
-- Name: TABLE widget_type; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE widget_type IS 'All types of Widgets will be listed in this table';


--
-- Name: COLUMN widget_type.hc_type; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN widget_type.hc_type IS 'Hight Chart Type text';


--
-- Name: women_aefi_rep_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE women_aefi_rep_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.women_aefi_rep_id_seq OWNER TO postgres;

--
-- Name: women_aefi_rep; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE women_aefi_rep (
    id integer DEFAULT nextval('women_aefi_rep_id_seq'::regclass) NOT NULL,
    procode character varying(1) DEFAULT 3 NOT NULL,
    distcode character varying(3) NOT NULL,
    tcode character varying(6) NOT NULL,
    uncode character varying(9) NOT NULL,
    village text,
    casename text,
    gender integer DEFAULT 0,
    dob date,
    age integer DEFAULT 0,
    years integer DEFAULT 0,
    months integer DEFAULT 0,
    weeks integer DEFAULT 0,
    fathername text,
    husbandname text,
    cellnumber text,
    mc_bcg integer DEFAULT 0,
    mc_convulsion integer DEFAULT 0,
    mc_severe integer DEFAULT 0,
    mc_unconscious integer DEFAULT 0,
    mc_abscess integer DEFAULT 0,
    mc_respiratory integer DEFAULT 0,
    mc_fever integer DEFAULT 0,
    mc_swelling integer DEFAULT 0,
    mc_rash integer DEFAULT 0,
    mc_other text,
    mc_treatment integer DEFAULT 0,
    mc_hospitalized integer DEFAULT 0,
    mc_hosp_address text,
    vacc_date date,
    vacc_name text,
    vacc_manufacturer text,
    vacc_exp date,
    vacc_center text,
    vacc_vaccinator text,
    rep_person text,
    rep_desg text,
    rep_date date,
    no_reporting_units integer,
    no_reported integer,
    no_reported_ontime integer,
    datefrom date,
    dateto date,
    week integer NOT NULL,
    no_aefi_cases integer DEFAULT 0,
    death character varying(3),
    date_aefi_onset date,
    submitted_by character varying(100),
    submitted_desg character varying(100),
    aefi_cases text,
    year integer NOT NULL,
    fweek character varying(7),
    submitted_date date,
    editted_date date,
    is_temp_saved character varying(1) DEFAULT 1 NOT NULL,
    facode character varying(6),
    vcode character varying(12),
    women_registration_no character varying(30),
    vacc_batch text,
    is_mobile_entry integer
);


ALTER TABLE public.women_aefi_rep OWNER TO postgres;

--
-- Name: zero_report_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE zero_report_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999999999999
    CACHE 1
    CYCLE;


ALTER TABLE public.zero_report_id_seq OWNER TO postgres;

--
-- Name: zero_report; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE zero_report (
    id integer DEFAULT nextval('zero_report_id_seq'::regclass) NOT NULL,
    facode character varying(6),
    fweek character varying(7),
    year character varying(4),
    week character varying(2),
    datefrom date,
    dateto date,
    report_submitted integer DEFAULT 0,
    measle_cases integer DEFAULT 0,
    measle_deaths integer DEFAULT 0,
    afp_cases integer DEFAULT 0,
    afp_deaths integer DEFAULT 0,
    tb_cases integer DEFAULT 0,
    tb_deaths integer DEFAULT 0,
    diarrhea_cases integer DEFAULT 0,
    diarrhea_deaths integer DEFAULT 0,
    diphtheria_cases integer DEFAULT 0,
    diphtheria_deaths integer DEFAULT 0,
    hepatits_cases integer DEFAULT 0,
    hepatits_deaths integer DEFAULT 0,
    meningitis_cases integer DEFAULT 0,
    meningitis_deaths integer DEFAULT 0,
    nnt_cases integer DEFAULT 0,
    nnt_deaths integer DEFAULT 0,
    pertusis_cases integer DEFAULT 0,
    pertusis_deaths integer DEFAULT 0,
    pneumonia_cases integer DEFAULT 0,
    pneumonia_deaths integer DEFAULT 0,
    submitted_date date,
    updated_date date,
    group_id integer,
    procode character varying(1) DEFAULT 3 NOT NULL,
    distcode character varying(3) NOT NULL,
    urti_cases integer DEFAULT 0,
    urti_deaths integer DEFAULT 0,
    pneumonia_great_five_cases integer DEFAULT 0,
    pneumonia_great_five_deaths integer DEFAULT 0,
    sari_cases integer DEFAULT 0,
    sari_deaths integer DEFAULT 0,
    diarrhea_great_five_cases integer DEFAULT 0,
    diarrhea_great_five_deaths integer DEFAULT 0,
    bd_cases integer DEFAULT 0,
    bd_deaths integer DEFAULT 0,
    ad_cases integer DEFAULT 0,
    ad_deaths integer DEFAULT 0,
    tf_cases integer DEFAULT 0,
    tf_deaths integer DEFAULT 0,
    avh_cases integer DEFAULT 0,
    avh_deaths integer DEFAULT 0,
    dhf_cases integer DEFAULT 0,
    dhf_deaths integer DEFAULT 0,
    df_cases integer DEFAULT 0,
    df_deaths integer DEFAULT 0,
    cchf_cases integer DEFAULT 0,
    cchf_deaths integer DEFAULT 0,
    cl_cases integer DEFAULT 0,
    cl_deaths integer DEFAULT 0,
    vl_cases integer DEFAULT 0,
    vl_deaths integer DEFAULT 0,
    mal_cases integer DEFAULT 0,
    mal_deaths integer DEFAULT 0,
    puo_cases integer DEFAULT 0,
    puo_deaths integer DEFAULT 0,
    psy_cases integer DEFAULT 0,
    psy_deaths integer DEFAULT 0,
    undis_cases integer DEFAULT 0,
    undis_deaths integer DEFAULT 0,
    is_temp_saved character varying(1) DEFAULT 1,
    aefi_cases integer DEFAULT 0,
    aefi_deaths integer DEFAULT 0,
    anthrax_cases integer,
    anthrax_deaths integer,
    dogbite_cases integer,
    dogbite_deaths integer,
    aids_cases integer,
    aids_deaths integer,
    scabies_cases integer,
    scabies_deaths integer,
    covid_cases integer DEFAULT 0,
    covid_deaths integer DEFAULT 0
);


ALTER TABLE public.zero_report OWNER TO postgres;

--
-- Name: zeroreportcompliance_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE zeroreportcompliance_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 993372036854775807
    CACHE 1;


ALTER TABLE public.zeroreportcompliance_id_seq OWNER TO postgres;

--
-- Name: zeroreportcompliance; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE zeroreportcompliance (
    id integer DEFAULT nextval('zeroreportcompliance_id_seq'::regclass) NOT NULL,
    year character varying(4) DEFAULT 0,
    procode character varying(1) DEFAULT 3,
    distcode character varying(3) DEFAULT 0,
    duewk01 integer DEFAULT 0,
    duewk02 integer DEFAULT 0,
    duewk03 integer DEFAULT 0,
    duewk04 integer DEFAULT 0,
    duewk05 integer DEFAULT 0,
    duewk06 integer DEFAULT 0,
    duewk07 integer DEFAULT 0,
    duewk08 integer DEFAULT 0,
    duewk09 integer DEFAULT 0,
    duewk10 integer DEFAULT 0,
    duewk11 integer DEFAULT 0,
    duewk12 integer DEFAULT 0,
    duewk13 integer DEFAULT 0,
    duewk14 integer DEFAULT 0,
    duewk15 integer DEFAULT 0,
    duewk16 integer DEFAULT 0,
    duewk17 integer DEFAULT 0,
    duewk18 integer DEFAULT 0,
    duewk19 integer DEFAULT 0,
    duewk20 integer DEFAULT 0,
    duewk21 integer DEFAULT 0,
    duewk22 integer DEFAULT 0,
    duewk23 integer DEFAULT 0,
    duewk24 integer DEFAULT 0,
    duewk25 integer DEFAULT 0,
    duewk26 integer DEFAULT 0,
    duewk27 integer DEFAULT 0,
    duewk28 integer DEFAULT 0,
    duewk29 integer DEFAULT 0,
    duewk30 integer DEFAULT 0,
    duewk31 integer DEFAULT 0,
    duewk32 integer DEFAULT 0,
    duewk33 integer DEFAULT 0,
    duewk34 integer DEFAULT 0,
    duewk35 integer DEFAULT 0,
    duewk36 integer DEFAULT 0,
    duewk37 integer DEFAULT 0,
    duewk38 integer DEFAULT 0,
    duewk39 integer DEFAULT 0,
    duewk40 integer DEFAULT 0,
    duewk41 integer DEFAULT 0,
    duewk42 integer DEFAULT 0,
    duewk43 integer DEFAULT 0,
    duewk44 integer DEFAULT 0,
    duewk45 integer DEFAULT 0,
    duewk46 integer DEFAULT 0,
    duewk47 integer DEFAULT 0,
    duewk48 integer DEFAULT 0,
    duewk49 integer DEFAULT 0,
    duewk50 integer DEFAULT 0,
    duewk51 integer DEFAULT 0,
    duewk52 integer DEFAULT 0,
    duewk53 integer DEFAULT 0,
    duewk54 integer DEFAULT 0,
    subwk01 integer DEFAULT 0,
    subwk02 integer DEFAULT 0,
    subwk03 integer DEFAULT 0,
    subwk04 integer DEFAULT 0,
    subwk05 integer DEFAULT 0,
    subwk06 integer DEFAULT 0,
    subwk07 integer DEFAULT 0,
    subwk08 integer DEFAULT 0,
    subwk09 integer DEFAULT 0,
    subwk10 integer DEFAULT 0,
    subwk11 integer DEFAULT 0,
    subwk12 integer DEFAULT 0,
    subwk13 integer DEFAULT 0,
    subwk14 integer DEFAULT 0,
    subwk15 integer DEFAULT 0,
    subwk16 integer DEFAULT 0,
    subwk17 integer DEFAULT 0,
    subwk18 integer DEFAULT 0,
    subwk19 integer DEFAULT 0,
    subwk20 integer DEFAULT 0,
    subwk21 integer DEFAULT 0,
    subwk22 integer DEFAULT 0,
    subwk23 integer DEFAULT 0,
    subwk24 integer DEFAULT 0,
    subwk25 integer DEFAULT 0,
    subwk26 integer DEFAULT 0,
    subwk27 integer DEFAULT 0,
    subwk28 integer DEFAULT 0,
    subwk29 integer DEFAULT 0,
    subwk30 integer DEFAULT 0,
    subwk31 integer DEFAULT 0,
    subwk32 integer DEFAULT 0,
    subwk33 integer DEFAULT 0,
    subwk34 integer DEFAULT 0,
    subwk35 integer DEFAULT 0,
    subwk36 integer DEFAULT 0,
    subwk37 integer DEFAULT 0,
    subwk38 integer DEFAULT 0,
    subwk39 integer DEFAULT 0,
    subwk40 integer DEFAULT 0,
    subwk41 integer DEFAULT 0,
    subwk42 integer DEFAULT 0,
    subwk43 integer DEFAULT 0,
    subwk44 integer DEFAULT 0,
    subwk45 integer DEFAULT 0,
    subwk46 integer DEFAULT 0,
    subwk47 integer DEFAULT 0,
    subwk48 integer DEFAULT 0,
    subwk49 integer DEFAULT 0,
    subwk50 integer DEFAULT 0,
    subwk51 integer DEFAULT 0,
    subwk52 integer DEFAULT 0,
    subwk53 integer DEFAULT 0,
    subwk54 integer DEFAULT 0,
    tsubwk01 integer DEFAULT 0,
    tsubwk02 integer DEFAULT 0,
    tsubwk03 integer DEFAULT 0,
    tsubwk04 integer DEFAULT 0,
    tsubwk05 integer DEFAULT 0,
    tsubwk06 integer DEFAULT 0,
    tsubwk07 integer DEFAULT 0,
    tsubwk08 integer DEFAULT 0,
    tsubwk09 integer DEFAULT 0,
    tsubwk10 integer DEFAULT 0,
    tsubwk11 integer DEFAULT 0,
    tsubwk12 integer DEFAULT 0,
    tsubwk13 integer DEFAULT 0,
    tsubwk14 integer DEFAULT 0,
    tsubwk15 integer DEFAULT 0,
    tsubwk16 integer DEFAULT 0,
    tsubwk17 integer DEFAULT 0,
    tsubwk18 integer DEFAULT 0,
    tsubwk19 integer DEFAULT 0,
    tsubwk20 integer DEFAULT 0,
    tsubwk21 integer DEFAULT 0,
    tsubwk22 integer DEFAULT 0,
    tsubwk23 integer DEFAULT 0,
    tsubwk24 integer DEFAULT 0,
    tsubwk25 integer DEFAULT 0,
    tsubwk26 integer DEFAULT 0,
    tsubwk27 integer DEFAULT 0,
    tsubwk28 integer DEFAULT 0,
    tsubwk29 integer DEFAULT 0,
    tsubwk30 integer DEFAULT 0,
    tsubwk31 integer DEFAULT 0,
    tsubwk32 integer DEFAULT 0,
    tsubwk33 integer DEFAULT 0,
    tsubwk34 integer DEFAULT 0,
    tsubwk35 integer DEFAULT 0,
    tsubwk36 integer DEFAULT 0,
    tsubwk37 integer DEFAULT 0,
    tsubwk38 integer DEFAULT 0,
    tsubwk39 integer DEFAULT 0,
    tsubwk40 integer DEFAULT 0,
    tsubwk41 integer DEFAULT 0,
    tsubwk42 integer DEFAULT 0,
    tsubwk43 integer DEFAULT 0,
    tsubwk44 integer DEFAULT 0,
    tsubwk45 integer DEFAULT 0,
    tsubwk46 integer DEFAULT 0,
    tsubwk47 integer DEFAULT 0,
    tsubwk48 integer DEFAULT 0,
    tsubwk49 integer DEFAULT 0,
    tsubwk50 integer DEFAULT 0,
    tsubwk51 integer DEFAULT 0,
    tsubwk52 integer DEFAULT 0,
    tsubwk53 integer DEFAULT 0,
    tsubwk54 integer DEFAULT 0,
    flag integer DEFAULT 0
);


ALTER TABLE public.zeroreportcompliance OWNER TO postgres;

--
-- Name: pk_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY abroad_cases ALTER COLUMN pk_id SET DEFAULT nextval('abroad_cases_pk_id_seq'::regclass);


--
-- Name: fwee; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY aefi_rep ALTER COLUMN fwee SET DEFAULT nextval('aefi_rep_fwee_seq'::regclass);


--
-- Name: pk_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cerv_support ALTER COLUMN pk_id SET DEFAULT nextval('cerv_support_pk_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY corona_case_investigation_form_db ALTER COLUMN id SET DEFAULT nextval('corona_case_investigation_db_seq'::regclass);


--
-- Name: pk_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY country_visits ALTER COLUMN pk_id SET DEFAULT nextval('country_visits_pk_id_seq'::regclass);


--
-- Name: abroad_cases_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY abroad_cases
    ADD CONSTRAINT abroad_cases_pkey PRIMARY KEY (pk_id);


--
-- Name: access_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY access_types
    ADD CONSTRAINT access_types_pkey PRIMARY KEY (pk_id);


--
-- Name: adjustment_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY adjustment_type
    ADD CONSTRAINT adjustment_type_pkey PRIMARY KEY (id);


--
-- Name: adv_report_fields_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY adv_report_fields
    ADD CONSTRAINT adv_report_fields_pkey PRIMARY KEY (report_fields_id);


--
-- Name: adv_reports_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY adv_reports
    ADD CONSTRAINT adv_reports_pkey PRIMARY KEY (report_id);


--
-- Name: aefi_case_investigation_form_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY aefi_case_investigation_form
    ADD CONSTRAINT aefi_case_investigation_form_pkey PRIMARY KEY (id);


--
-- Name: aefi_rep_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY aefi_rep
    ADD CONSTRAINT aefi_rep_pkey PRIMARY KEY (id);


--
-- Name: afp_case_investigation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY afp_case_investigation
    ADD CONSTRAINT afp_case_investigation_pkey PRIMARY KEY (id);


--
-- Name: auto_req_Cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY auto_req_cache
    ADD CONSTRAINT "auto_req_Cache_pkey" PRIMARY KEY (id);


--
-- Name: bankinfo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY bankinfo
    ADD CONSTRAINT bankinfo_pkey PRIMARY KEY (bankid);


--
-- Name: case_clinical_representation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY case_clinical_representation
    ADD CONSTRAINT case_clinical_representation_pkey PRIMARY KEY (id);


--
-- Name: case_investigation_db_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY case_investigation_db
    ADD CONSTRAINT case_investigation_db_pkey PRIMARY KEY (id);


--
-- Name: case_response_tbl _pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY case_response_tbl
    ADD CONSTRAINT "case_response_tbl _pkey" PRIMARY KEY (id);


--
-- Name: caseepidcount_master_procode_distcode_case_type_dosenumber__key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY caseepidcount_master
    ADD CONSTRAINT caseepidcount_master_procode_distcode_case_type_dosenumber__key UNIQUE (procode, distcode, case_type, dosenumber, gender, year, selected_week);


--
-- Name: cerv_child_registration_cardno_reg_facode_year_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cerv_child_registration
    ADD CONSTRAINT cerv_child_registration_cardno_reg_facode_year_key UNIQUE (cardno, reg_facode, year);


--
-- Name: cerv_child_registration_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cerv_child_registration
    ADD CONSTRAINT cerv_child_registration_pkey PRIMARY KEY (recno);


--
-- Name: cerv_mother_registration_cardno_year_reg_facode_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cerv_mother_registration
    ADD CONSTRAINT cerv_mother_registration_cardno_year_reg_facode_key UNIQUE (cardno, year, reg_facode);


--
-- Name: cerv_mother_registration_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cerv_mother_registration
    ADD CONSTRAINT cerv_mother_registration_pkey PRIMARY KEY (recno);


--
-- Name: cerv_shifted_childs_history_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cerv_shifted_childs_history
    ADD CONSTRAINT cerv_shifted_childs_history_pkey PRIMARY KEY (id);


--
-- Name: cerv_support_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cerv_support
    ADD CONSTRAINT cerv_support_pkey PRIMARY KEY (pk_id);


--
-- Name: cerv_villages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cerv_villages
    ADD CONSTRAINT cerv_villages_pkey PRIMARY KEY (id);


--
-- Name: cerv_villages_vcode_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cerv_villages
    ADD CONSTRAINT cerv_villages_vcode_key UNIQUE (vcode);


--
-- Name: corona_case_investigation_form_db_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY corona_case_investigation_form_db
    ADD CONSTRAINT corona_case_investigation_form_db_pkey PRIMARY KEY (id);


--
-- Name: country_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY country
    ADD CONSTRAINT country_pkey PRIMARY KEY (pk_id);


--
-- Name: country_visits_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY country_visits
    ADD CONSTRAINT country_visits_pkey PRIMARY KEY (pk_id);


--
-- Name: custom_filters_detail_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY custom_filters_detail
    ADD CONSTRAINT custom_filters_detail_pkey PRIMARY KEY (pk_id);


--
-- Name: custom_filters_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY custom_filters
    ADD CONSTRAINT custom_filters_name_key UNIQUE (name);


--
-- Name: custom_filters_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY custom_filters
    ADD CONSTRAINT custom_filters_pkey PRIMARY KEY (pk_id);


--
-- Name: custom_filters_title_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY custom_filters
    ADD CONSTRAINT custom_filters_title_key UNIQUE (title);


--
-- Name: custom_indicators_defination_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY custom_indicators_defination
    ADD CONSTRAINT custom_indicators_defination_name_key UNIQUE (name);


--
-- Name: custom_indicators_defination_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY custom_indicators_defination
    ADD CONSTRAINT custom_indicators_defination_pkey PRIMARY KEY (pk_id);


--
-- Name: dashboard_widget_detail_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY dashboard_widget_detail
    ADD CONSTRAINT dashboard_widget_detail_pkey PRIMARY KEY (pk_id);


--
-- Name: dashboardhide_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY dashboardhide
    ADD CONSTRAINT dashboardhide_pkey PRIMARY KEY (pk_id);


--
-- Name: dashboardinfo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY dashboardinfo
    ADD CONSTRAINT dashboardinfo_pkey PRIMARY KEY (pk_id);


--
-- Name: data_maping_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY data_maping
    ADD CONSTRAINT data_maping_pkey PRIMARY KEY (pk_id);


--
-- Name: diphtheria_case_response_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY diphtheria_case_response
    ADD CONSTRAINT diphtheria_case_response_pkey PRIMARY KEY (id);


--
-- Name: district_freeze_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY district_freeze
    ADD CONSTRAINT district_freeze_pkey PRIMARY KEY (fr_id);


--
-- Name: districts_distcode_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY districts
    ADD CONSTRAINT districts_distcode_key UNIQUE (distcode);


--
-- Name: districts_population_distcode_year_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY districts_population
    ADD CONSTRAINT districts_population_distcode_year_key UNIQUE (distcode, year);


--
-- Name: districts_wise_maps_paths_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY districts_wise_maps_paths
    ADD CONSTRAINT districts_wise_maps_paths_pkey PRIMARY KEY (id);


--
-- Name: epi_cc_asset_status_history_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_cc_asset_status_history
    ADD CONSTRAINT epi_cc_asset_status_history_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_cc_asset_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_cc_asset_types
    ADD CONSTRAINT epi_cc_asset_types_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_cc_coldchain_main_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_cc_coldchain_main
    ADD CONSTRAINT epi_cc_coldchain_main_pkey PRIMARY KEY (asset_id);


--
-- Name: epi_cc_equipment_types_equipment_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_cc_equipment_types
    ADD CONSTRAINT epi_cc_equipment_types_equipment_name_key UNIQUE (equipment_type_name);


--
-- Name: epi_cc_equipment_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_cc_equipment_types
    ADD CONSTRAINT epi_cc_equipment_types_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_cc_makes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_cc_makes
    ADD CONSTRAINT epi_cc_makes_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_cc_models_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_cc_models
    ADD CONSTRAINT epi_cc_models_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_cc_status_list_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_cc_status_list
    ADD CONSTRAINT epi_cc_status_list_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_cc_warehouse_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_cc_warehouse_types
    ADD CONSTRAINT epi_cc_warehouse_types_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_ccm_cold_rooms_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_ccm_cold_rooms
    ADD CONSTRAINT epi_ccm_cold_rooms_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_ccm_generators_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_ccm_generators
    ADD CONSTRAINT epi_ccm_generators_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_ccm_vehicles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_ccm_vehicles
    ADD CONSTRAINT epi_ccm_vehicles_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_ccm_voltage_regulators_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_ccm_voltage_regulators
    ADD CONSTRAINT epi_ccm_voltage_regulators_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_childreg_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_childreg
    ADD CONSTRAINT epi_childreg_pkey PRIMARY KEY (id);


--
-- Name: epi_coldroom_questionnaire_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_coldroom_questionnaire
    ADD CONSTRAINT epi_coldroom_questionnaire_pkey PRIMARY KEY (id);


--
-- Name: epi_consumption_adjustment_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_consumption_adjustment
    ADD CONSTRAINT epi_consumption_adjustment_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_consumption_detail_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_consumption_detail
    ADD CONSTRAINT epi_consumption_detail_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_consumption_master_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_consumption_master
    ADD CONSTRAINT epi_consumption_master_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_fmonths_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_fmonths
    ADD CONSTRAINT epi_fmonths_pkey PRIMARY KEY (id);


--
-- Name: epi_fmonths_shortname_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_fmonths
    ADD CONSTRAINT epi_fmonths_shortname_key UNIQUE (shortname);


--
-- Name: epi_funding_source_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_funding_source
    ADD CONSTRAINT epi_funding_source_pkey PRIMARY KEY (id);


--
-- Name: epi_generator_questionnaire_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_generator_questionnaire
    ADD CONSTRAINT epi_generator_questionnaire_pkey PRIMARY KEY (id);


--
-- Name: epi_geo_levels_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_geo_levels
    ADD CONSTRAINT epi_geo_levels_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_hf_questionnaire_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_hf_questionnaire
    ADD CONSTRAINT epi_hf_questionnaire_pkey PRIMARY KEY (id);


--
-- Name: epi_item_categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_item_categories
    ADD CONSTRAINT epi_item_categories_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_item_pack_sizes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_item_pack_sizes
    ADD CONSTRAINT epi_item_pack_sizes_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_item_units_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_item_units
    ADD CONSTRAINT epi_item_units_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_items_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_items
    ADD CONSTRAINT epi_items_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_manufacturer_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_manufacturer
    ADD CONSTRAINT epi_manufacturer_pkey PRIMARY KEY (id);


--
-- Name: epi_modules_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_modules
    ADD CONSTRAINT epi_modules_name_key UNIQUE (name);


--
-- Name: epi_modules_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_modules
    ADD CONSTRAINT epi_modules_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_non_ccm_locations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_non_ccm_locations
    ADD CONSTRAINT epi_non_ccm_locations_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_non_ccm_rack_information_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_non_ccm_rack_information
    ADD CONSTRAINT epi_non_ccm_rack_information_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_refrigerator_questionnaire_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_refrigerator_questionnaire
    ADD CONSTRAINT epi_refrigerator_questionnaire_pkey PRIMARY KEY (id);


--
-- Name: epi_stakeholder_activites_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_stakeholder_activities
    ADD CONSTRAINT epi_stakeholder_activites_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_stakeholder_item_pack_siz_stakeholder_id_item_pack_size_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_stakeholder_item_pack_sizes
    ADD CONSTRAINT epi_stakeholder_item_pack_siz_stakeholder_id_item_pack_size_key UNIQUE (stakeholder_id, item_pack_size_id);


--
-- Name: epi_stakeholder_item_pack_sizes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_stakeholder_item_pack_sizes
    ADD CONSTRAINT epi_stakeholder_item_pack_sizes_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_stakeholder_sectors_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_stakeholder_sectors
    ADD CONSTRAINT epi_stakeholder_sectors_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_stakeholder_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_stakeholder_types
    ADD CONSTRAINT epi_stakeholder_types_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_stakeholders_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_stakeholders
    ADD CONSTRAINT epi_stakeholders_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_stock_batch_history_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_stock_batch_history
    ADD CONSTRAINT epi_stock_batch_history_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_stock_batch_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_stock_batch
    ADD CONSTRAINT epi_stock_batch_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_stock_detail_history_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_stock_detail_history
    ADD CONSTRAINT epi_stock_detail_history_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_stock_detail_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_stock_detail
    ADD CONSTRAINT epi_stock_detail_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_stock_management_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_stock_management
    ADD CONSTRAINT epi_stock_management_pkey PRIMARY KEY (id);


--
-- Name: epi_stock_master_fed_fetch_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_stock_master_fed_fetch
    ADD CONSTRAINT epi_stock_master_fed_fetch_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_stock_master_history_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_stock_master_history
    ADD CONSTRAINT epi_stock_master_history_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_stock_master_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_stock_master
    ADD CONSTRAINT epi_stock_master_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_transaction_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_transaction_types
    ADD CONSTRAINT epi_transaction_types_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_voltage_questionnaire_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_voltage_questionnaire
    ADD CONSTRAINT epi_voltage_questionnaire_pkey PRIMARY KEY (id);


--
-- Name: epi_vvm_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_vvm_types
    ADD CONSTRAINT epi_vvm_types_pkey PRIMARY KEY (pk_id);


--
-- Name: epi_weeks_epi_week_numb_year_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_weeks
    ADD CONSTRAINT epi_weeks_epi_week_numb_year_key UNIQUE (epi_week_numb, year);


--
-- Name: epi_weeks_fweek_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_weeks
    ADD CONSTRAINT epi_weeks_fweek_key UNIQUE (fweek);


--
-- Name: epi_weeks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_weeks
    ADD CONSTRAINT epi_weeks_pkey PRIMARY KEY (recid);


--
-- Name: epidcount_db_distcode_case_type_year_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epidcount_db
    ADD CONSTRAINT epidcount_db_distcode_case_type_year_key UNIQUE (distcode, case_type, year);


--
-- Name: epidcount_db_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epidcount_db
    ADD CONSTRAINT epidcount_db_pkey PRIMARY KEY (pk_id);


--
-- Name: epidmr_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epidmr
    ADD CONSTRAINT epidmr_pkey PRIMARY KEY (id);


--
-- Name: epifieldtitles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epifieldstitle
    ADD CONSTRAINT epifieldtitles_pkey PRIMARY KEY (recid);


--
-- Name: epiusers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epiusers
    ADD CONSTRAINT epiusers_pkey PRIMARY KEY (username);


--
-- Name: epiusers_username_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epiusers
    ADD CONSTRAINT epiusers_username_key UNIQUE (username);


--
-- Name: fac_mvrf_db_facode_fmonth_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY fac_mvrf_db
    ADD CONSTRAINT fac_mvrf_db_facode_fmonth_key UNIQUE (facode, fmonth);


--
-- Name: fac_mvrf_db_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY fac_mvrf_db
    ADD CONSTRAINT fac_mvrf_db_pkey PRIMARY KEY (id);


--
-- Name: fac_mvrf_od_db_facode_fmonth_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY fac_mvrf_od_db
    ADD CONSTRAINT fac_mvrf_od_db_facode_fmonth_key UNIQUE (facode, fmonth);


--
-- Name: fac_mvrf_od_db_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY fac_mvrf_od_db
    ADD CONSTRAINT fac_mvrf_od_db_pkey PRIMARY KEY (id);


--
-- Name: facilities_facode_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY facilities
    ADD CONSTRAINT facilities_facode_key UNIQUE (facode);


--
-- Name: facilities_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY facilities
    ADD CONSTRAINT facilities_pkey PRIMARY KEY (id);


--
-- Name: facilities_population_facode_year_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY facilities_population
    ADD CONSTRAINT facilities_population_facode_year_key UNIQUE (facode, year);


--
-- Name: facilities_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY facilities_types
    ADD CONSTRAINT facilities_types_pkey PRIMARY KEY (id);


--
-- Name: feedback_db_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY feedback_db
    ADD CONSTRAINT feedback_db_pkey PRIMARY KEY (recid);


--
-- Name: filter_series_names_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY filter_series_names
    ADD CONSTRAINT filter_series_names_pkey PRIMARY KEY (pk_id);


--
-- Name: flcf_vacc_mr1_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY flcf_vacc_mr
    ADD CONSTRAINT flcf_vacc_mr1_pkey PRIMARY KEY (id);


--
-- Name: flcf_vacc_mr_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY flcf_vacc_mr_old
    ADD CONSTRAINT flcf_vacc_mr_pkey PRIMARY KEY (id);


--
-- Name: form_AI_vaccine_columns_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY form_a1_vaccine_columns
    ADD CONSTRAINT "form_AI_vaccine_columns_pkey" PRIMARY KEY (id);


--
-- Name: form_AI_vaccine_main_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY form_a1_vaccine_main
    ADD CONSTRAINT "form_AI_vaccine_main_pkey" PRIMARY KEY (id);


--
-- Name: form_AI_vaccine_titles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY form_a1_vaccine_titles
    ADD CONSTRAINT "form_AI_vaccine_titles_pkey" PRIMARY KEY (id);


--
-- Name: form_a1_fed_vaccine_columns_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY form_a1_fed_vaccine_columns
    ADD CONSTRAINT form_a1_fed_vaccine_columns_pkey PRIMARY KEY (id);


--
-- Name: form_a1_fed_vaccine_main_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY form_a1_fed_vaccine_main
    ADD CONSTRAINT form_a1_fed_vaccine_main_pkey PRIMARY KEY (id);


--
-- Name: form_a2_vaccine_columns_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY form_a2_vaccine_columns
    ADD CONSTRAINT form_a2_vaccine_columns_pkey PRIMARY KEY (id);


--
-- Name: form_a2_vaccine_main_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY form_a2_vaccine_main
    ADD CONSTRAINT form_a2_vaccine_main_pkey PRIMARY KEY (id);


--
-- Name: form_b_cr_facode_fmonth_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY form_b_cr
    ADD CONSTRAINT form_b_cr_facode_fmonth_key UNIQUE (facode, fmonth);


--
-- Name: form_b_cr_new_facode_fmonth_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY form_b_cr_p
    ADD CONSTRAINT form_b_cr_new_facode_fmonth_key UNIQUE (facode, fmonth);


--
-- Name: form_b_cr_new_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY form_b_cr_p
    ADD CONSTRAINT form_b_cr_new_pkey PRIMARY KEY (id);


--
-- Name: form_b_cr_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY form_b_cr
    ADD CONSTRAINT form_b_cr_pkey PRIMARY KEY (id);


--
-- Name: geo_levels_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY geo_levels
    ADD CONSTRAINT geo_levels_pkey PRIMARY KEY (pk_id);


--
-- Name: group_filters_info_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY group_filters_info
    ADD CONSTRAINT group_filters_info_pkey PRIMARY KEY (pk_id);


--
-- Name: hf_quarterplan_dates_db_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hf_quarterplan_dates_dbold
    ADD CONSTRAINT hf_quarterplan_dates_db_pkey PRIMARY KEY (id);


--
-- Name: hf_quarterplan_dates_db_pkey1; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hf_quarterplan_dates_db
    ADD CONSTRAINT hf_quarterplan_dates_db_pkey1 PRIMARY KEY (pk_id);


--
-- Name: hf_quarterplan_db_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hf_quarterplan_dbold
    ADD CONSTRAINT hf_quarterplan_db_pkey PRIMARY KEY (recid);


--
-- Name: hf_quarterplan_db_pkey1; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hf_quarterplan_db
    ADD CONSTRAINT hf_quarterplan_db_pkey1 PRIMARY KEY (pk_id);


--
-- Name: hf_quarterplan_nm_db_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hf_quarterplan_nm_dbold
    ADD CONSTRAINT hf_quarterplan_nm_db_pkey PRIMARY KEY (pk_id);


--
-- Name: hf_quarterplan_nm_db_pkey1; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hf_quarterplan_nm_db
    ADD CONSTRAINT hf_quarterplan_nm_db_pkey1 PRIMARY KEY (pk_id);


--
-- Name: hr_app_users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hr_app_users
    ADD CONSTRAINT hr_app_users_pkey PRIMARY KEY (pk_id);


--
-- Name: hr_db_code_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hr_db
    ADD CONSTRAINT hr_db_code_key UNIQUE (code);


--
-- Name: hr_db_history_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hr_db_history
    ADD CONSTRAINT hr_db_history_pkey PRIMARY KEY (id);


--
-- Name: hr_db_nic_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hr_db
    ADD CONSTRAINT hr_db_nic_key UNIQUE (nic);


--
-- Name: hr_db_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hr_db
    ADD CONSTRAINT hr_db_pkey PRIMARY KEY (id);


--
-- Name: hr_leave_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hr_leave
    ADD CONSTRAINT hr_leave_pkey PRIMARY KEY (id);


--
-- Name: hr_levels_code_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hr_levels
    ADD CONSTRAINT hr_levels_code_key UNIQUE (code);


--
-- Name: hr_levels_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hr_levels
    ADD CONSTRAINT hr_levels_name_key UNIQUE (name);


--
-- Name: hr_levels_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hr_levels
    ADD CONSTRAINT hr_levels_pkey PRIMARY KEY (id);


--
-- Name: hr_sub_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hr_sub_types
    ADD CONSTRAINT hr_sub_types_pkey PRIMARY KEY (id);


--
-- Name: hr_sub_types_type_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hr_sub_types
    ADD CONSTRAINT hr_sub_types_type_id_key UNIQUE (type_id);


--
-- Name: hr_trainings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hr_trainings
    ADD CONSTRAINT hr_trainings_pkey PRIMARY KEY (id);


--
-- Name: hr_types_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hr_types
    ADD CONSTRAINT hr_types_name_key UNIQUE (name);


--
-- Name: hr_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hr_types
    ADD CONSTRAINT hr_types_pkey PRIMARY KEY (id);


--
-- Name: hrdb_hrcode_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hrdb
    ADD CONSTRAINT hrdb_hrcode_key UNIQUE (hrcode);


--
-- Name: hrdb_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY hrdb
    ADD CONSTRAINT hrdb_pkey PRIMARY KEY (id);


--
-- Name: id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "hr_db_history_backup 1/6/2020"
    ADD CONSTRAINT id PRIMARY KEY (id);


--
-- Name: indcat_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY indcat
    ADD CONSTRAINT indcat_pkey PRIMARY KEY (indid);


--
-- Name: indicator_column_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY indicator_column
    ADD CONSTRAINT indicator_column_pkey PRIMARY KEY (indcol);


--
-- Name: indicator_filters_indicator_id_filter_id_sub_indicator_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY indicator_filters
    ADD CONSTRAINT indicator_filters_indicator_id_filter_id_sub_indicator_id_key UNIQUE (indicator_id, filter_id, sub_indicator_id);


--
-- Name: indicator_filters_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY indicator_filters
    ADD CONSTRAINT indicator_filters_pkey PRIMARY KEY ("pk_id ");


--
-- Name: indicator_main_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY indicator_main
    ADD CONSTRAINT indicator_main_pkey PRIMARY KEY (indmain);


--
-- Name: indicator_periodic_multiplier_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY indicator_periodic_multiplier
    ADD CONSTRAINT indicator_periodic_multiplier_pkey PRIMARY KEY (pk_id);


--
-- Name: login_log_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY login_log
    ADD CONSTRAINT login_log_pkey PRIMARY KEY (login_id);


--
-- Name: lookup_detail_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY lookup_detail
    ADD CONSTRAINT lookup_detail_pkey PRIMARY KEY (pk_id);


--
-- Name: lookup_master_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY lookup_master
    ADD CONSTRAINT lookup_master_id_key UNIQUE (id);


--
-- Name: lookup_master_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY lookup_master
    ADD CONSTRAINT lookup_master_pkey PRIMARY KEY (pk_id);


--
-- Name: manage_epi_vacc_items_record_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY manage_epi_vacc_items_record
    ADD CONSTRAINT manage_epi_vacc_items_record_pkey PRIMARY KEY (id);


--
-- Name: manage_epi_vacc_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY manage_epi_vacc
    ADD CONSTRAINT manage_epi_vacc_pkey PRIMARY KEY (recid);


--
-- Name: master_history unique trans num; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_stock_master_history
    ADD CONSTRAINT "master_history unique trans num" UNIQUE (transaction_number);


--
-- Name: measle_case_investigation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY measle_case_investigation
    ADD CONSTRAINT measle_case_investigation_pkey PRIMARY KEY (id);


--
-- Name: measles_case_response_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY measles_case_response
    ADD CONSTRAINT measles_case_response_pkey PRIMARY KEY (id);


--
-- Name: measles_outbreak_linelist_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY measles_outbreak_linelist
    ADD CONSTRAINT measles_outbreak_linelist_pkey PRIMARY KEY (id);


--
-- Name: med_techniciandb_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY med_techniciandb
    ADD CONSTRAINT med_techniciandb_pkey PRIMARY KEY (id);


--
-- Name: med_techniciandb_techniciancode_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY med_techniciandb
    ADD CONSTRAINT med_techniciandb_techniciancode_key UNIQUE (techniciancode);


--
-- Name: menu_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY menu
    ADD CONSTRAINT menu_pkey PRIMARY KEY (id);


--
-- Name: monthly_outuc_coverage_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY monthly_outuc_coverage
    ADD CONSTRAINT monthly_outuc_coverage_pkey PRIMARY KEY (pk_id);


--
-- Name: msr_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY msr
    ADD CONSTRAINT msr_pkey PRIMARY KEY (id);


--
-- Name: nnt_cases_linelist_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY nnt_cases_linelist
    ADD CONSTRAINT nnt_cases_linelist_pkey PRIMARY KEY (id);


--
-- Name: nnt_investigation_form_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY nnt_investigation_form
    ADD CONSTRAINT nnt_investigation_form_pkey PRIMARY KEY (id);


--
-- Name: pk_fac_status; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY facilities_status_backup
    ADD CONSTRAINT pk_fac_status PRIMARY KEY (id);


--
-- Name: pk_fac_status_1; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY facilities_status
    ADD CONSTRAINT pk_fac_status_1 PRIMARY KEY (id);


--
-- Name: products_details_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY products_details
    ADD CONSTRAINT products_details_id_key UNIQUE (id);


--
-- Name: products_details_name_doses_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY products_details
    ADD CONSTRAINT products_details_name_doses_key UNIQUE (name, doses);


--
-- Name: products_details_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY products_details
    ADD CONSTRAINT products_details_name_key UNIQUE (name);


--
-- Name: products_details_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY products_details
    ADD CONSTRAINT products_details_pkey PRIMARY KEY (id);


--
-- Name: products_details_product_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY products_details
    ADD CONSTRAINT products_details_product_id_key UNIQUE (product_id);


--
-- Name: products_doses_details_cr_product_id_vacc_dose_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY products_doses_details
    ADD CONSTRAINT products_doses_details_cr_product_id_vacc_dose_id_key UNIQUE (cr_product_id, vacc_dose_id);


--
-- Name: products_doses_details_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY products_doses_details
    ADD CONSTRAINT products_doses_details_id_key UNIQUE (id);


--
-- Name: products_doses_details_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY products_doses_details
    ADD CONSTRAINT products_doses_details_pkey PRIMARY KEY (id);


--
-- Name: provinces_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY provinces
    ADD CONSTRAINT provinces_pkey PRIMARY KEY (pro_id);


--
-- Name: red_strategy_db_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY red_strategy_db
    ADD CONSTRAINT red_strategy_db_pkey PRIMARY KEY (recid);


--
-- Name: roles_menu_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY roles_menu
    ADD CONSTRAINT roles_menu_pkey PRIMARY KEY (id);


--
-- Name: sanctioned_posts_db_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sanctioned_posts_db
    ADD CONSTRAINT sanctioned_posts_db_pkey PRIMARY KEY (recid);


--
-- Name: session_plan_db_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY session_plan_db
    ADD CONSTRAINT session_plan_db_pkey PRIMARY KEY (recid);


--
-- Name: situation_analysis_db_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY situation_analysis_db
    ADD CONSTRAINT situation_analysis_db_pkey PRIMARY KEY (recid);


--
-- Name: special_activities_db_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY special_activities_db
    ADD CONSTRAINT special_activities_db_pkey PRIMARY KEY (recid);


--
-- Name: stakeholder_activities_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY stakeholder_activities
    ADD CONSTRAINT stakeholder_activities_pkey PRIMARY KEY (pk_id);


--
-- Name: stakeholder_item_pack_sizes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY stakeholder_item_pack_sizes
    ADD CONSTRAINT stakeholder_item_pack_sizes_pkey PRIMARY KEY (pk_id);


--
-- Name: stakeholder_sectors_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY stakeholder_sectors
    ADD CONSTRAINT stakeholder_sectors_pkey PRIMARY KEY (pk_id);


--
-- Name: stakeholder_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY stakeholder_types
    ADD CONSTRAINT stakeholder_types_pkey PRIMARY KEY (pk_id);


--
-- Name: stakeholders_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY stakeholders
    ADD CONSTRAINT stakeholders_pkey PRIMARY KEY (pk_id);


--
-- Name: sub_indicators_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sub_indicators
    ADD CONSTRAINT sub_indicators_pkey PRIMARY KEY (pk_id);


--
-- Name: supervisordb_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY supervisordb
    ADD CONSTRAINT supervisordb_pkey PRIMARY KEY (id);


--
-- Name: supervisordb_supervisorcode_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY supervisordb
    ADD CONSTRAINT supervisordb_supervisorcode_key UNIQUE (supervisorcode);


--
-- Name: surveillance_cases_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY surveillance_cases_types
    ADD CONSTRAINT surveillance_cases_types_pkey PRIMARY KEY (id);


--
-- Name: technician_checkin_details_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY technician_checkin_details
    ADD CONSTRAINT technician_checkin_details_pkey PRIMARY KEY (recno);


--
-- Name: techniciandb_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY techniciandb
    ADD CONSTRAINT techniciandb_pkey PRIMARY KEY (id);


--
-- Name: techniciandb_techniciancode_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY techniciandb
    ADD CONSTRAINT techniciandb_techniciancode_key UNIQUE (techniciancode);


--
-- Name: tehsil_population_tcode_year_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tehsil_population
    ADD CONSTRAINT tehsil_population_tcode_year_key UNIQUE (tcode, year);


--
-- Name: tehsil_tcode_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tehsil
    ADD CONSTRAINT tehsil_tcode_key UNIQUE (tcode);


--
-- Name: training_types_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY training_types
    ADD CONSTRAINT training_types_name_key UNIQUE (name);


--
-- Name: training_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY training_types
    ADD CONSTRAINT training_types_pkey PRIMARY KEY (id);


--
-- Name: transport_questionnaire_cols_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY transport_questionnaire_cols
    ADD CONSTRAINT transport_questionnaire_cols_pkey PRIMARY KEY (id);


--
-- Name: transport_questionnaire_main_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY transport_questionnaire_main
    ADD CONSTRAINT transport_questionnaire_main_pkey PRIMARY KEY (id);


--
-- Name: uc_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY testuc
    ADD CONSTRAINT uc_pk PRIMARY KEY (uncode);


--
-- Name: uc_wise_maps_pathsn_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY uc_wise_maps_paths_old
    ADD CONSTRAINT uc_wise_maps_pathsn_pkey PRIMARY KEY (id);


--
-- Name: uc_wise_maps_pathsnew_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY uc_wise_maps_paths
    ADD CONSTRAINT uc_wise_maps_pathsnew_pkey PRIMARY KEY (id);


--
-- Name: unioncouncil_population_uncode_year_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY unioncouncil_population
    ADD CONSTRAINT unioncouncil_population_uncode_year_key UNIQUE (uncode, year);


--
-- Name: unioncouncil_uncode_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY unioncouncil
    ADD CONSTRAINT unioncouncil_uncode_key UNIQUE (uncode);


--
-- Name: unique order; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_items
    ADD CONSTRAINT "unique order" UNIQUE (list_order);


--
-- Name: unique record; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_consumption_master
    ADD CONSTRAINT "unique record" UNIQUE (fmonth, facode);


--
-- Name: user_level_db_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY user_level_db
    ADD CONSTRAINT user_level_db_pkey PRIMARY KEY (id);


--
-- Name: user_level_db_userlevel_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY user_level_db
    ADD CONSTRAINT user_level_db_userlevel_key UNIQUE (userlevel);


--
-- Name: user_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY user_roles
    ADD CONSTRAINT user_roles_pkey PRIMARY KEY (id);


--
-- Name: user_transaction_log_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY user_transaction_log
    ADD CONSTRAINT user_transaction_log_pkey PRIMARY KEY (log_id);


--
-- Name: user_types_db_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY user_types_db
    ADD CONSTRAINT user_types_db_pkey PRIMARY KEY (id);


--
-- Name: vacc_carriers_cols_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY vacc_carriers_cols
    ADD CONSTRAINT vacc_carriers_cols_pkey PRIMARY KEY (id);


--
-- Name: vacc_carriers_main_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY vacc_carriers_main
    ADD CONSTRAINT vacc_carriers_main_pkey PRIMARY KEY (id);


--
-- Name: vacc_ri_mr_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY vacc_ri_mr
    ADD CONSTRAINT vacc_ri_mr_pkey PRIMARY KEY (id);


--
-- Name: vaccine_vials_daily_record_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY vaccine_vials_daily_record
    ADD CONSTRAINT vaccine_vials_daily_record_pkey PRIMARY KEY (pk_id);


--
-- Name: village_merger_merger_group_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY village_merger
    ADD CONSTRAINT village_merger_merger_group_id_key UNIQUE (merger_group_id);


--
-- Name: village_merger_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY village_merger
    ADD CONSTRAINT village_merger_pkey PRIMARY KEY (pk_id);


--
-- Name: villages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY villages
    ADD CONSTRAINT villages_pkey PRIMARY KEY (id);


--
-- Name: villages_population_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY villages_population
    ADD CONSTRAINT villages_population_id_key UNIQUE (id);


--
-- Name: villages_population_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY villages_population
    ADD CONSTRAINT villages_population_pkey PRIMARY KEY (id);


--
-- Name: villages_population_vcode_year_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY villages_population
    ADD CONSTRAINT villages_population_vcode_year_key UNIQUE (vcode, year);


--
-- Name: villages_vcode_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY villages
    ADD CONSTRAINT villages_vcode_key UNIQUE (vcode);


--
-- Name: vlmis_com_vaccines_name_doses_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_vacc_products_details
    ADD CONSTRAINT vlmis_com_vaccines_name_doses_key UNIQUE (name, doses);


--
-- Name: vlmis_com_vaccines_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_vacc_products_details
    ADD CONSTRAINT vlmis_com_vaccines_pkey PRIMARY KEY (id);


--
-- Name: vlmis_com_vaccines_vacc_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY epi_vacc_products_details
    ADD CONSTRAINT vlmis_com_vaccines_vacc_id_key UNIQUE (vacc_id);


--
-- Name: vpd_diseases_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY vpd_diseases
    ADD CONSTRAINT vpd_diseases_id_key UNIQUE (id);


--
-- Name: vvm_stages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY vvm_stages
    ADD CONSTRAINT vvm_stages_pkey PRIMARY KEY (id);


--
-- Name: vvm_types_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY vvm_types
    ADD CONSTRAINT vvm_types_pkey PRIMARY KEY (id);


--
-- Name: weekly_vpd_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "weekly_vpd old"
    ADD CONSTRAINT weekly_vpd_pkey PRIMARY KEY (recid);


--
-- Name: weekly_vpd_pkey1; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY weekly_vpd
    ADD CONSTRAINT weekly_vpd_pkey1 PRIMARY KEY (recid);


--
-- Name: widget_filters_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY widget_filters
    ADD CONSTRAINT widget_filters_pkey PRIMARY KEY (pk_id);


--
-- Name: widget_indicators_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY widget_indicators
    ADD CONSTRAINT widget_indicators_pkey PRIMARY KEY (pk_id);


--
-- Name: widget_indicators_widget_id_indicator_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY widget_indicators
    ADD CONSTRAINT widget_indicators_widget_id_indicator_id_key UNIQUE (widget_id, indicator_id);


--
-- Name: widget_quries_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY widget_quries
    ADD CONSTRAINT widget_quries_pkey PRIMARY KEY (pk_id);


--
-- Name: widget_type_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY widget_type
    ADD CONSTRAINT widget_type_name_key UNIQUE (name);


--
-- Name: widget_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY widget_type
    ADD CONSTRAINT widget_type_pkey PRIMARY KEY (pk_id);


--
-- Name: women_aefi_rep_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY women_aefi_rep
    ADD CONSTRAINT women_aefi_rep_pkey PRIMARY KEY (id);


--
-- Name: zero_report_facode_fweek_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY zero_report
    ADD CONSTRAINT zero_report_facode_fweek_key UNIQUE (facode, fweek);


--
-- Name: zero_report_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY zero_report
    ADD CONSTRAINT zero_report_pkey PRIMARY KEY (id);


