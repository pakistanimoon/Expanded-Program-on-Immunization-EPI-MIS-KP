
--
-- Name: OtherDiseaseCompliance; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX "OtherDiseaseCompliance" ON weekly_vpd USING btree (distcode, tcode, uncode, facode, fweek);


--
-- Name: batch transactions; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX "batch transactions" ON epi_stock_batch USING btree (number, batch_master_id, status, item_pack_size_id, warehouse_type_id, code);


--
-- Name: cervchildregistration_indexon_techniciancode; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX cervchildregistration_indexon_techniciancode ON cerv_child_registration USING btree (uncode, techniciancode);


--
-- Name: closing value; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX "closing value" ON epi_consumption_detail USING btree (closing_vials);


--
-- Name: detail transactions; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX "detail transactions" ON epi_stock_detail USING btree (quantity, vvm_stage, is_received, adjustment_type, stock_master_id, stock_batch_id);


--
-- Name: districtwiseindex; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX districtwiseindex ON fac_mvrf_db USING btree (distcode, fmonth);


--
-- Name: districtwiseindex_od; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX districtwiseindex_od ON fac_mvrf_od_db USING btree (distcode, fmonth);


--
-- Name: districtwiseindexzeroreport; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX districtwiseindexzeroreport ON zero_report USING btree (fweek, distcode);


--
-- Name: districtwisequriesindex; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX districtwisequriesindex ON districts USING btree (distcode);


--
-- Name: districtwisevillagesindex; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX districtwisevillagesindex ON villages USING btree (distcode);


--
-- Name: districtwisevillagespopulationindex; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX districtwisevillagespopulationindex ON villages_population USING btree (year, distcode);


--
-- Name: facilitywisevillagespopulationindex; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX facilitywisevillagespopulationindex ON villages_population USING btree (year, facode);


--
-- Name: fordistrictsearch; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fordistrictsearch ON epi_consumption_master USING btree (distcode);


--
-- Name: hr_db_history_index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX hr_db_history_index ON hr_db_history USING btree (code, post_hr_sub_type_id);


--
-- Name: indexforreports; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX indexforreports ON facilities USING btree (facode, distcode, hf_type);


--
-- Name: mainlinelistcasetypeindex; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX mainlinelistcasetypeindex ON case_investigation_db USING btree (distcode, fweek, case_type);


--
-- Name: master transactions; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX "master transactions" ON epi_stock_master USING btree (transaction_date, transaction_number, transaction_type_id, from_warehouse_type_id, from_warehouse_code, to_warehouse_type_id, to_warehouse_code, parent_id, stakeholder_activity_id);


--
-- Name: provincewiseindexzeroreport; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX provincewiseindexzeroreport ON zero_report USING btree (fweek, procode);


--
-- Name: provincewisepopulationqueryindex; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX provincewisepopulationqueryindex ON province_population USING btree (procode, year);


--
-- Name: provincewisequeryindex; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX provincewisequeryindex ON provinces USING btree (procode);


--
-- Name: provincewisevillagespopulationindex; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX provincewisevillagespopulationindex ON villages_population USING btree (year, procode);


--
-- Name: reportFormBcr; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX "reportFormBcr" ON form_b_cr USING btree (facode, uncode, tcode, distcode, procode, fmonth);


--
-- Name: reportsIndexMeasles; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX "reportsIndexMeasles" ON measle_case_investigation USING btree (facode, uncode, tcode, distcode, fweek);


--
-- Name: reportsIndexTehsil; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX "reportsIndexTehsil" ON tehsil USING btree (tehsil, distcode, population, tcode);


--
-- Name: reportssearchindex; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX reportssearchindex ON unioncouncil USING btree (uncode, tcode, distcode, procode);


--
-- Name: search index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX "search index" ON epi_consumption_detail USING btree (main_id, item_id);


--
-- Name: searchbydate; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX searchbydate ON epi_stock_master USING btree (transaction_date, draft, to_warehouse_type_id, to_warehouse_code, from_warehouse_type_id, from_warehouse_code);


--
-- Name: statuswiseitem; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX statuswiseitem ON epi_stock_batch USING btree (item_pack_size_id, status);


--
-- Name: store codes; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX "store codes" ON epi_consumption_master USING btree (fmonth, procode, distcode, tcode, uncode, facode);


--
-- Name: techniciancheckindetails_indexon_techniciancode; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX techniciancheckindetails_indexon_techniciancode ON technician_checkin_details USING btree (techniciancode);


--
-- Name: tehsilwiseindex; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX tehsilwiseindex ON fac_mvrf_db USING btree (tcode, fmonth);


--
-- Name: tehsilwiseindex_od; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX tehsilwiseindex_od ON fac_mvrf_od_db USING btree (tcode, fmonth);


--
-- Name: tehsilwisevillagesindex; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX tehsilwisevillagesindex ON villages USING btree (tcode);


--
-- Name: ucwisevillagesindex; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX ucwisevillagesindex ON villages USING btree (uncode);


--
-- Name: ucwisevillagespopulationindex; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX ucwisevillagespopulationindex ON villages_population USING btree (year, uncode);


--
-- Name: uncodewiseindex; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX uncodewiseindex ON fac_mvrf_db USING btree (uncode, fmonth);


--
-- Name: unioncouncilwiseindex_od; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX unioncouncilwiseindex_od ON fac_mvrf_od_db USING btree (uncode, fmonth);


--
-- Name: weeklydistrictwisequeryindex; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX weeklydistrictwisequeryindex ON case_investigation_db USING btree (distcode, fweek);


--
-- Name: weeklyfacilitywisequeryindex; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX weeklyfacilitywisequeryindex ON case_investigation_db USING btree (facode, fweek);


--
-- Name: weeklyprovincewisequeryindex; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX weeklyprovincewisequeryindex ON case_investigation_db USING btree (procode, fweek);


--
-- Name: weeklytehsilwisequeryindex; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX weeklytehsilwisequeryindex ON case_investigation_db USING btree (tcode, fweek);


--
-- Name: weeklyucwisequeryindex; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX weeklyucwisequeryindex ON case_investigation_db USING btree (uncode, fweek);


--
-- Name: womensearchuncodeindex; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX womensearchuncodeindex ON cerv_mother_registration USING btree (techniciancode, uncode);


--
-- Name: zeroreportcomplianceindex; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX zeroreportcomplianceindex ON zeroreportcompliance USING btree (year, distcode);


--
-- Name: cache_compliance_consumption_delete; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER cache_compliance_consumption_delete AFTER DELETE ON form_b_cr FOR EACH ROW EXECUTE PROCEDURE consumptioncompliance_delete();

ALTER TABLE form_b_cr DISABLE TRIGGER cache_compliance_consumption_delete;


--
-- Name: cache_compliance_consumption_delete; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER cache_compliance_consumption_delete AFTER DELETE ON epi_consumption_master FOR EACH ROW EXECUTE PROCEDURE consumption_master_delete_compliance();


--
-- Name: cache_compliance_consumption_insert; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER cache_compliance_consumption_insert AFTER INSERT ON form_b_cr FOR EACH ROW EXECUTE PROCEDURE consumptioncompliance_insert();

ALTER TABLE form_b_cr DISABLE TRIGGER cache_compliance_consumption_insert;


--
-- Name: cache_compliance_consumption_insert; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER cache_compliance_consumption_insert AFTER INSERT ON epi_consumption_master FOR EACH ROW EXECUTE PROCEDURE consumption_master_insert_compliance();


--
-- Name: cache_compliance_consumption_update; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER cache_compliance_consumption_update AFTER UPDATE ON form_b_cr FOR EACH ROW EXECUTE PROCEDURE consumptioncompliance_update();

ALTER TABLE form_b_cr DISABLE TRIGGER cache_compliance_consumption_update;


--
-- Name: cache_compliance_consumption_update; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER cache_compliance_consumption_update AFTER UPDATE ON epi_consumption_master FOR EACH ROW EXECUTE PROCEDURE consumption_master_update_compliance();


--
-- Name: cache_compliance_vaccination_delete; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER cache_compliance_vaccination_delete AFTER DELETE ON fac_mvrf_db FOR EACH ROW EXECUTE PROCEDURE vaccinationcompliance_delete();


--
-- Name: cache_compliance_vaccination_insert; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER cache_compliance_vaccination_insert AFTER INSERT ON fac_mvrf_db FOR EACH ROW EXECUTE PROCEDURE vaccinationcompliance_insert();


--
-- Name: cache_compliance_vaccination_update; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER cache_compliance_vaccination_update AFTER UPDATE ON fac_mvrf_db FOR EACH ROW EXECUTE PROCEDURE vaccinationcompliance_update();


--
-- Name: cache_compliance_zeroreport_delete; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER cache_compliance_zeroreport_delete AFTER DELETE ON zero_report FOR EACH ROW EXECUTE PROCEDURE zeroreportcompliance_delete();


--
-- Name: cache_compliance_zeroreport_insert; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER cache_compliance_zeroreport_insert AFTER INSERT ON zero_report FOR EACH ROW EXECUTE PROCEDURE zeroreportcompliance_insert();


--
-- Name: case_investigation_db_delete_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER case_investigation_db_delete_trigger AFTER DELETE ON case_investigation_db FOR EACH ROW EXECUTE PROCEDURE case_investigation_db_delete();


--
-- Name: case_investigation_db_insert_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER case_investigation_db_insert_trigger AFTER INSERT ON case_investigation_db FOR EACH ROW EXECUTE PROCEDURE case_investigation_db_insert();


--
-- Name: case_investigation_db_udpate_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER case_investigation_db_udpate_trigger AFTER UPDATE ON case_investigation_db FOR EACH ROW EXECUTE PROCEDURE case_investigation_db_update();


--
-- Name: caseapfcount_master_insert_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER caseapfcount_master_insert_trigger AFTER INSERT ON afp_case_investigation FOR EACH ROW EXECUTE PROCEDURE caseafpepidcount_master_insert();


--
-- Name: caseapfcount_master_update_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER caseapfcount_master_update_trigger AFTER UPDATE ON afp_case_investigation FOR EACH ROW EXECUTE PROCEDURE caseafpepidcount_master_update();


--
-- Name: caseepidcount_master_insert_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER caseepidcount_master_insert_trigger AFTER INSERT ON case_investigation_db FOR EACH ROW EXECUTE PROCEDURE caseepidcount_master_insert();


--
-- Name: caseepidcount_master_update_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER caseepidcount_master_update_trigger AFTER UPDATE ON case_investigation_db FOR EACH ROW EXECUTE PROCEDURE caseepidcount_master_update();


--
-- Name: casenntcount_master_insert_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER casenntcount_master_insert_trigger AFTER INSERT ON nnt_investigation_form FOR EACH ROW EXECUTE PROCEDURE casenntepidcount_master_insert();


--
-- Name: casenntcount_master_update_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER casenntcount_master_update_trigger AFTER UPDATE ON nnt_investigation_form FOR EACH ROW EXECUTE PROCEDURE casenntepidcount_master_update();


--
-- Name: check_facilities_references; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER check_facilities_references BEFORE DELETE ON facilities FOR EACH ROW EXECUTE PROCEDURE facilities_record_check_delete();


--
-- Name: coldchain_record_check_delete; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER coldchain_record_check_delete BEFORE DELETE ON epi_cc_coldchain_main FOR EACH ROW EXECUTE PROCEDURE coldchain_record_check_delete();


--
-- Name: duecompliance_status_update; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER duecompliance_status_update AFTER DELETE OR UPDATE ON facilities_status FOR EACH ROW EXECUTE PROCEDURE update_monthwise_district_due_reports_in_compliances();


--
-- Name: facilities_cumulative_population_insert; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER facilities_cumulative_population_insert AFTER INSERT OR UPDATE ON facilities_population FOR EACH ROW EXECUTE PROCEDURE facilities_cumulative_population_insert();


--
-- Name: flcf_vacc_mr_trigger; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER flcf_vacc_mr_trigger BEFORE INSERT OR UPDATE ON flcf_vacc_mr FOR EACH ROW EXECUTE PROCEDURE flcf_vacc_mr_trigger();


--
-- Name: make_province_year_wise_population; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER make_province_year_wise_population AFTER INSERT OR DELETE OR UPDATE ON districts_population FOR EACH ROW EXECUTE PROCEDURE province_population_calculation();


--
-- Name: trigger_update_on_facilities_insert; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger_update_on_facilities_insert AFTER INSERT ON facilities FOR EACH ROW EXECUTE PROCEDURE update_monthwise_district_due_reports_in_fac_insert_compliances();


--
-- Name: trigger_update_on_facilities_update; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER trigger_update_on_facilities_update AFTER UPDATE OF is_vacc_fac, hf_type ON facilities FOR EACH ROW EXECUTE PROCEDURE update_monthwise_district_due_reports_in_compliances();


--
-- Name: abroad_cases_case_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY abroad_cases
    ADD CONSTRAINT abroad_cases_case_id_fkey FOREIGN KEY (case_id) REFERENCES corona_case_investigation_form_db(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: bid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hr_db
    ADD CONSTRAINT bid_fkey FOREIGN KEY (bid) REFERENCES bankinfo(bankid);


--
-- Name: bid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hr_db_new
    ADD CONSTRAINT bid_fkey FOREIGN KEY (bid) REFERENCES bankinfo(bankid);


--
-- Name: case_clinical_representation_case_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY case_clinical_representation
    ADD CONSTRAINT case_clinical_representation_case_type_id_fkey FOREIGN KEY (case_type_id) REFERENCES surveillance_cases_types(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: ccm_asset_sub_type_id-epi_cc_asset_types_pk_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_ccm_cold_rooms
    ADD CONSTRAINT "ccm_asset_sub_type_id-epi_cc_asset_types_pk_id_fkey" FOREIGN KEY (ccm_sub_asset_type_id) REFERENCES epi_cc_asset_types(pk_id);


--
-- Name: ccm_voltage_regulators_cold_chain_fk1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_ccm_voltage_regulators
    ADD CONSTRAINT ccm_voltage_regulators_cold_chain_fk1 FOREIGN KEY (ccm_id) REFERENCES epi_cc_coldchain_main(asset_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: code_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hr_db_history
    ADD CONSTRAINT code_fkey FOREIGN KEY (code) REFERENCES hr_db(code);


--
-- Name: code_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hr_app_users
    ADD CONSTRAINT code_fkey FOREIGN KEY (fk_hr_code) REFERENCES hr_db(code);


--
-- Name: created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hr_levels
    ADD CONSTRAINT created_by_fkey FOREIGN KEY (created_by) REFERENCES epiusers(username);


--
-- Name: created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hr_types
    ADD CONSTRAINT created_by_fkey FOREIGN KEY (created_by) REFERENCES epiusers(username);


--
-- Name: created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hr_sub_types
    ADD CONSTRAINT created_by_fkey FOREIGN KEY (created_by) REFERENCES epiusers(username);


--
-- Name: created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hr_db
    ADD CONSTRAINT created_by_fkey FOREIGN KEY (created_by) REFERENCES epiusers(username);


--
-- Name: created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hr_trainings
    ADD CONSTRAINT created_by_fkey FOREIGN KEY (created_by) REFERENCES epiusers(username);


--
-- Name: created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY training_types
    ADD CONSTRAINT created_by_fkey FOREIGN KEY (created_by) REFERENCES epiusers(username);


--
-- Name: created_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hr_db_new
    ADD CONSTRAINT created_by_fkey FOREIGN KEY (created_by) REFERENCES epiusers(username);


--
-- Name: custom_filters_detail_main_filter_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY custom_filters_detail
    ADD CONSTRAINT custom_filters_detail_main_filter_id_fkey FOREIGN KEY (main_filter_id) REFERENCES custom_filters(pk_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: custom_indicators_defination_module_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY custom_indicators_defination
    ADD CONSTRAINT custom_indicators_defination_module_id_fkey FOREIGN KEY (module_id) REFERENCES epi_modules(pk_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: dashboard_widget_detail_dashboard_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY dashboard_widget_detail
    ADD CONSTRAINT dashboard_widget_detail_dashboard_id_fkey FOREIGN KEY (dashboard_id) REFERENCES dashboardinfo(pk_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: dashboard_widget_detail_indicator_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY dashboard_widget_detail
    ADD CONSTRAINT dashboard_widget_detail_indicator_id_fkey FOREIGN KEY (indicator_id) REFERENCES custom_indicators_defination(pk_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: dashboard_widget_detail_module_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY dashboard_widget_detail
    ADD CONSTRAINT dashboard_widget_detail_module_id_fkey FOREIGN KEY (module_id) REFERENCES epi_modules(pk_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: dashboard_widget_detail_sub_indicator_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY dashboard_widget_detail
    ADD CONSTRAINT dashboard_widget_detail_sub_indicator_id_fkey FOREIGN KEY (sub_indicator_id) REFERENCES sub_indicators(pk_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: dashboard_widget_detail_widget_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY dashboard_widget_detail
    ADD CONSTRAINT dashboard_widget_detail_widget_type_id_fkey FOREIGN KEY (widget_type_id) REFERENCES widget_type(pk_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: dashboardhide_dashboardinfo_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY dashboardhide
    ADD CONSTRAINT dashboardhide_dashboardinfo_id_fkey FOREIGN KEY (dashboardinfo_id) REFERENCES dashboardinfo(pk_id);


--
-- Name: dashboardhide_username_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY dashboardhide
    ADD CONSTRAINT dashboardhide_username_fkey FOREIGN KEY (username) REFERENCES epiusers(username);


--
-- Name: dashboardinfo_access_type_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY dashboardinfo
    ADD CONSTRAINT dashboardinfo_access_type_fkey FOREIGN KEY (access_type) REFERENCES access_types(pk_id);


--
-- Name: epi_cc_asset_status_history-districts_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_cc_asset_status_history
    ADD CONSTRAINT "epi_cc_asset_status_history-districts_fkey" FOREIGN KEY (distcode) REFERENCES districts(distcode) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: epi_cc_asset_status_history-epi_cc_asset_types_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_cc_asset_status_history
    ADD CONSTRAINT "epi_cc_asset_status_history-epi_cc_asset_types_fkey" FOREIGN KEY (assets_type_id) REFERENCES epi_cc_asset_types(pk_id);


--
-- Name: epi_cc_asset_status_history-epi_cc_warehouse_types_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_cc_asset_status_history
    ADD CONSTRAINT "epi_cc_asset_status_history-epi_cc_warehouse_types_fkey" FOREIGN KEY (warehouse_type_id) REFERENCES epi_cc_warehouse_types(pk_id);


--
-- Name: epi_cc_asset_status_history-facilities_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_cc_asset_status_history
    ADD CONSTRAINT "epi_cc_asset_status_history-facilities_fkey" FOREIGN KEY (facode) REFERENCES facilities(facode) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: epi_cc_asset_status_history-tehsil_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_cc_asset_status_history
    ADD CONSTRAINT "epi_cc_asset_status_history-tehsil_fkey" FOREIGN KEY (tcode) REFERENCES tehsil(tcode) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: epi_cc_asset_status_history-unioncoucil_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_cc_asset_status_history
    ADD CONSTRAINT "epi_cc_asset_status_history-unioncoucil_fkey" FOREIGN KEY (uncode) REFERENCES unioncouncil(uncode) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: epi_cc_coldchain_main-districts_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_cc_coldchain_main
    ADD CONSTRAINT "epi_cc_coldchain_main-districts_fkey" FOREIGN KEY (distcode) REFERENCES districts(distcode) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: epi_cc_coldchain_main-facilities_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_cc_coldchain_main
    ADD CONSTRAINT "epi_cc_coldchain_main-facilities_fkey" FOREIGN KEY (facode) REFERENCES facilities(facode) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: epi_cc_coldchain_main-tehsil_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_cc_coldchain_main
    ADD CONSTRAINT "epi_cc_coldchain_main-tehsil_fkey" FOREIGN KEY (tcode) REFERENCES tehsil(tcode) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: epi_cc_coldchain_main-unioncouncil_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_cc_coldchain_main
    ADD CONSTRAINT "epi_cc_coldchain_main-unioncouncil_fkey" FOREIGN KEY (uncode) REFERENCES unioncouncil(uncode) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: epi_cc_coldchain_main_epi_cc_asset_types_fkey ; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_cc_coldchain_main
    ADD CONSTRAINT "epi_cc_coldchain_main_epi_cc_asset_types_fkey " FOREIGN KEY (ccm_sub_asset_type_id) REFERENCES epi_cc_asset_types(pk_id);


--
-- Name: epi_cc_coldchain_main_epi_cc_models_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_cc_coldchain_main
    ADD CONSTRAINT epi_cc_coldchain_main_epi_cc_models_fkey FOREIGN KEY (ccm_model_id) REFERENCES epi_cc_models(pk_id);


--
-- Name: epi_cc_coldchain_main_epi_cc_warehouse_types_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_cc_coldchain_main
    ADD CONSTRAINT epi_cc_coldchain_main_epi_cc_warehouse_types_fkey FOREIGN KEY (warehouse_type_id) REFERENCES epi_cc_warehouse_types(pk_id);


--
-- Name: epi_cc_models_ccm_asset_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_cc_models
    ADD CONSTRAINT epi_cc_models_ccm_asset_type_id_fkey FOREIGN KEY (ccm_sub_asset_type_id) REFERENCES epi_cc_asset_types(pk_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: epi_cc_models_ccm_make_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_cc_models
    ADD CONSTRAINT epi_cc_models_ccm_make_id_fkey FOREIGN KEY (ccm_make_id) REFERENCES epi_cc_makes(pk_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: epi_ccm_cold_rooms_ccm_id-epi_cc_coldchain_main_asset_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_ccm_cold_rooms
    ADD CONSTRAINT "epi_ccm_cold_rooms_ccm_id-epi_cc_coldchain_main_asset_id_fkey" FOREIGN KEY (ccm_id) REFERENCES epi_cc_coldchain_main(asset_id);


--
-- Name: epi_ccm_vehicles-ccm_coldchain_main_fkey 	; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_ccm_vehicles
    ADD CONSTRAINT "epi_ccm_vehicles-ccm_coldchain_main_fkey 	" FOREIGN KEY (ccm_id) REFERENCES epi_cc_coldchain_main(asset_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: epi_items_item_category_id_fke; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_items
    ADD CONSTRAINT epi_items_item_category_id_fke FOREIGN KEY (item_category_id) REFERENCES epi_item_categories(pk_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: filter_series_names_filter_detail_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY filter_series_names
    ADD CONSTRAINT filter_series_names_filter_detail_id_fkey FOREIGN KEY (filter_detail_id) REFERENCES custom_filters_detail(pk_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: filter_series_names_sub_indicator_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY filter_series_names
    ADD CONSTRAINT filter_series_names_sub_indicator_id_fkey FOREIGN KEY (sub_indicator_id) REFERENCES sub_indicators(pk_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: form_a1_fed_vaccine_columns_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY form_a1_fed_vaccine_columns
    ADD CONSTRAINT form_a1_fed_vaccine_columns_fkey FOREIGN KEY (main_id) REFERENCES form_a1_fed_vaccine_main(id);


--
-- Name: form_a1_vaccine_columns_main_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY form_a1_vaccine_columns
    ADD CONSTRAINT form_a1_vaccine_columns_main_id_fkey FOREIGN KEY (main_id) REFERENCES form_a1_vaccine_main(id);


--
-- Name: form_a2_vaccine_columns_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY form_a2_vaccine_columns
    ADD CONSTRAINT form_a2_vaccine_columns_fkey FOREIGN KEY (main_id) REFERENCES form_a2_vaccine_main(id);


--
-- Name: generator_id-coldchain_main_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_ccm_generators
    ADD CONSTRAINT "generator_id-coldchain_main_fkey" FOREIGN KEY (ccm_id) REFERENCES epi_cc_coldchain_main(asset_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: hr_code_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hr_trainings
    ADD CONSTRAINT hr_code_fkey FOREIGN KEY (hr_code) REFERENCES hr_db(code);


--
-- Name: hr_code_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hr_leave
    ADD CONSTRAINT hr_code_fkey FOREIGN KEY (hr_code) REFERENCES hr_db(code);


--
-- Name: hr_sub_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hr_db
    ADD CONSTRAINT hr_sub_type_id_fkey FOREIGN KEY (hr_sub_type_id) REFERENCES hr_sub_types(type_id);


--
-- Name: hr_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hr_sub_types
    ADD CONSTRAINT hr_type_id_fkey FOREIGN KEY (hr_type_id) REFERENCES hr_types(id);


--
-- Name: hr_type_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hr_db
    ADD CONSTRAINT hr_type_id_fkey FOREIGN KEY (hr_type_id) REFERENCES hr_types(id);


--
-- Name: indicator_filters_filter_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY indicator_filters
    ADD CONSTRAINT indicator_filters_filter_id_fkey FOREIGN KEY (filter_id) REFERENCES custom_filters(pk_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: indicator_filters_indicator_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY indicator_filters
    ADD CONSTRAINT indicator_filters_indicator_id_fkey FOREIGN KEY (indicator_id) REFERENCES custom_indicators_defination(pk_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: indicator_filters_sub_indicator_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY indicator_filters
    ADD CONSTRAINT indicator_filters_sub_indicator_id_fkey FOREIGN KEY (sub_indicator_id) REFERENCES sub_indicators(pk_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: level_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hr_db
    ADD CONSTRAINT level_fkey FOREIGN KEY (level) REFERENCES hr_levels(code);


--
-- Name: main_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_consumption_detail
    ADD CONSTRAINT main_id_fkey FOREIGN KEY (main_id) REFERENCES epi_consumption_master(pk_id);


--
-- Name: manage_epi_vacc_items_record_manage_vacc_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY manage_epi_vacc_items_record
    ADD CONSTRAINT manage_epi_vacc_items_record_manage_vacc_id_fkey FOREIGN KEY (manage_vacc_id) REFERENCES manage_epi_vacc(recid) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: master_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY lookup_detail
    ADD CONSTRAINT master_id_fk FOREIGN KEY (master_id) REFERENCES lookup_master(id);


--
-- Name: products_details_id_to_search_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY products_details
    ADD CONSTRAINT products_details_id_to_search_fkey FOREIGN KEY (id_to_search) REFERENCES form_a1_vaccine_titles(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: products_doses_details_cr_product_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY products_doses_details
    ADD CONSTRAINT products_doses_details_cr_product_id_fkey FOREIGN KEY (cr_product_id) REFERENCES products_details(id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: roles_menu_menu_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY roles_menu
    ADD CONSTRAINT roles_menu_menu_id_fkey FOREIGN KEY (menu_id) REFERENCES menu(id);


--
-- Name: roles_menu_role_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY roles_menu
    ADD CONSTRAINT roles_menu_role_id_fkey FOREIGN KEY (role_id) REFERENCES user_roles(id);


--
-- Name: sub_indicators_indicator_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sub_indicators
    ADD CONSTRAINT sub_indicators_indicator_id_fkey FOREIGN KEY (indicator_id) REFERENCES custom_indicators_defination(pk_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: sub_indicators_module_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sub_indicators
    ADD CONSTRAINT sub_indicators_module_id_fkey FOREIGN KEY (module_id) REFERENCES epi_modules(pk_id) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: tem_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY epi_consumption_detail
    ADD CONSTRAINT tem_id_fkey FOREIGN KEY (item_id) REFERENCES epi_item_pack_sizes(pk_id);


--
-- Name: training_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hr_trainings
    ADD CONSTRAINT training_id_fkey FOREIGN KEY (training_id) REFERENCES training_types(id);


--
-- Name: transport_questionnaire_cols_main_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY transport_questionnaire_cols
    ADD CONSTRAINT transport_questionnaire_cols_main_id_fkey FOREIGN KEY (main_id) REFERENCES transport_questionnaire_main(id);


--
-- Name: updated_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY hr_db
    ADD CONSTRAINT updated_by_fkey FOREIGN KEY (updated_by) REFERENCES epiusers(username);


--
-- Name: user_roles_level_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY user_roles
    ADD CONSTRAINT user_roles_level_fkey FOREIGN KEY (level) REFERENCES user_level_db(userlevel);


--
-- Name: user_roles_type_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY user_roles
    ADD CONSTRAINT user_roles_type_fkey FOREIGN KEY (type) REFERENCES user_types_db(id);


--
-- Name: vacc_carriers_cols_main_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY vacc_carriers_cols
    ADD CONSTRAINT vacc_carriers_cols_main_id_fkey FOREIGN KEY (main_id) REFERENCES vacc_carriers_main(id);


--
-- Name: weekly_vpd_cases_vpd_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY weekly_vpd_cases
    ADD CONSTRAINT weekly_vpd_cases_vpd_id_fkey FOREIGN KEY (vpd_id) REFERENCES "weekly_vpd old"(recid) ON UPDATE CASCADE ON DELETE CASCADE;