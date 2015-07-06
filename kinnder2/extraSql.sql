ALTER TABLE actividades DROP FOREIGN KEY actividades_md_news_letter_group_id_md_news_letter_group_id;
ALTER TABLE cobro DROP FOREIGN KEY cobro_cuenta_id_cuenta_id;
ALTER TABLE cuentapadre DROP FOREIGN KEY cuentapadre_cuenta_id_cuenta_id;
ALTER TABLE cuentapadre DROP FOREIGN KEY cuentapadre_progenitor_id_progenitor_id;
ALTER TABLE cuentausuario DROP FOREIGN KEY cuentausuario_cuenta_id_cuenta_id;
ALTER TABLE cuentausuario DROP FOREIGN KEY cuentausuario_usuario_id_usuario_id;
ALTER TABLE exoneracion DROP FOREIGN KEY exoneracion_usuario_id_usuario_id;
ALTER TABLE facturaFinal DROP FOREIGN KEY facturaFinal_cuenta_id_cuenta_id;
ALTER TABLE facturaFinalDetalle DROP FOREIGN KEY facturaFinalDetalle_factura_id_facturaFinal_id;
ALTER TABLE facturaUsuario DROP FOREIGN KEY facturaUsuario_usuario_id_usuario_id;
ALTER TABLE facturaUsuarioDetalle DROP FOREIGN KEY facturaUsuarioDetalle_factura_id_facturaUsuario_id;
ALTER TABLE facturausuariofinal DROP FOREIGN KEY facturausuariofinal_factura_final_id_facturaFinal_id;
ALTER TABLE facturausuariofinal DROP FOREIGN KEY facturausuariofinal_factura_usuario_id_facturaUsuario_id;
ALTER TABLE hermanos DROP FOREIGN KEY hermanos_usuario_from_usuario_id;
ALTER TABLE hermanos DROP FOREIGN KEY hermanos_usuario_to_usuario_id;
ALTER TABLE md_content DROP FOREIGN KEY md_content_md_user_id_md_user_id;
ALTER TABLE md_content_relation DROP FOREIGN KEY md_content_relation_md_content_id_first_md_content_id;
ALTER TABLE md_content_relation DROP FOREIGN KEY md_content_relation_md_content_id_second_md_content_id;
ALTER TABLE md_galeria_translation DROP FOREIGN KEY md_galeria_translation_id_md_galeria_id;
ALTER TABLE md_media_album DROP FOREIGN KEY md_media_album_md_media_content_id_md_media_content_id;
ALTER TABLE md_media_album DROP FOREIGN KEY md_media_album_md_media_id_md_media_id;
ALTER TABLE md_media_album_content DROP FOREIGN KEY md_media_album_content_md_media_album_id_md_media_album_id;
ALTER TABLE md_media_album_content DROP FOREIGN KEY md_media_album_content_md_media_content_id_md_media_content_id;
ALTER TABLE md_news_letter_group_sended DROP FOREIGN KEY mmmi;
ALTER TABLE md_news_letter_group_sended DROP FOREIGN KEY mmmi_1;
ALTER TABLE md_news_letter_group_user DROP FOREIGN KEY mmmi_2;
ALTER TABLE md_news_letter_group_user DROP FOREIGN KEY mmmi_3;
ALTER TABLE md_news_letter_user DROP FOREIGN KEY md_news_letter_user_md_user_id_md_user_id;
ALTER TABLE md_newsletter_content_sended DROP FOREIGN KEY mmmi_4;
ALTER TABLE md_newsletter_send DROP FOREIGN KEY md_newsletter_send_md_news_letter_user_id_md_news_letter_user_id;
ALTER TABLE md_newsletter_send DROP FOREIGN KEY mmmi_5;
ALTER TABLE md_passport DROP FOREIGN KEY md_passport_md_user_id_md_user_id;
ALTER TABLE md_passport_remember_key DROP FOREIGN KEY md_passport_remember_key_md_passport_id_md_passport_id;
ALTER TABLE md_user_search DROP FOREIGN KEY md_user_search_md_user_id_md_user_id;
ALTER TABLE pagos DROP FOREIGN KEY pagos_usuario_id_usuario_id;
ALTER TABLE progenitor DROP FOREIGN KEY progenitor_md_user_id_md_user_id;
ALTER TABLE usuario DROP FOREIGN KEY usuario_billetera_id_billetera_id;
ALTER TABLE usuario_actividades DROP FOREIGN KEY usuario_actividades_actividad_id_actividades_id;
ALTER TABLE usuario_actividades DROP FOREIGN KEY usuario_actividades_usuario_id_usuario_id;
ALTER TABLE usuario_progenitor DROP FOREIGN KEY usuario_progenitor_progenitor_id_progenitor_id;
ALTER TABLE usuario_progenitor DROP FOREIGN KEY usuario_progenitor_usuario_id_usuario_id;



