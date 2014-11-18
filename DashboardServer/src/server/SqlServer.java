package server;

import java.awt.Color;
import java.io.BufferedReader;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;

import javax.swing.JLabel;

import utils.BashUtils;

/**
 * 
 * @author Paco
 *
 */
public class SqlServer {
	
	private String sudopass = "";
	private JLabel label_status_mysql = null;
	
	/**
	 * 
	 * @param sudopass
	 * @param label_status_mysql
	 */
	public SqlServer(String sudopass, JLabel label_status_mysql) {
		this.sudopass = sudopass;
		this.label_status_mysql = label_status_mysql;
	}

	/**
	* Voir ports service MySQL
	*/
	public String listenPort_mysql(){
		String outfile ="";
		String pathfile="/etc/mysql/my.cnf";
		try{
			InputStream ips = new FileInputStream(pathfile);
			InputStreamReader ipsr = new InputStreamReader(ips);
			BufferedReader br = new BufferedReader(ipsr);
			String ligne="";
			while((ligne=br.readLine())!=null){
				if(ligne.contains("port")){ //filtrage lignes
					if(!ligne.contains("#")){
						outfile+=ligne+"\n";
					}
				}
				if(ligne.contains("bind-address")){
					outfile+=ligne+"\n";
				}
			}
			br.close();
			System.out.println(outfile);
		}
		catch(IOException e){
			e.printStackTrace();
		}
		return outfile;
	}

	/**
	* Voir statut service MySQL
	*/
	public void labelStatus_mysql(){
		String status_mysql = null;
		status_mysql = new BashUtils().outputCommand("service mysql status",""+sudopass);
		if(status_mysql.contains("start")){
			System.out.println("MySQL Start");
			label_status_mysql.setText("MySQL Start");
			label_status_mysql.setForeground(new Color(0,255,0)); //green
		}
		else if(status_mysql.contains("stop")){
			System.out.println("MySQL Stop");
			label_status_mysql.setText("MySQL Stop");
			label_status_mysql.setForeground(new Color(255,0,0)); //red
		}
		else{
			System.out.println("MySQL Unknow");
			label_status_mysql.setText("MySQL Unknow");
			label_status_mysql.setForeground(new Color(255,255,0)); //yellow
		}
	}

}//end of class
