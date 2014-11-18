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
public class WebServer {
	
	private String sudopass = "";
	private JLabel label_status_apache = null;
	
	/**
	 * 
	 * @param sudopass
	 * @param label_status_apache
	 */
	public WebServer(String sudopass, JLabel label_status_apache) {
		this.sudopass = sudopass;
		this.label_status_apache = label_status_apache;
	}

	/**
	 * 
	 * @return
	 */
	public String infos_www(){
		String outfile ="";
		String pathfile="/var/www/pageperso.php";
		try{
			InputStream ips = new FileInputStream(pathfile);
			InputStreamReader ipsr = new InputStreamReader(ips);
			BufferedReader br = new BufferedReader(ipsr);
			String ligne="";
			while((ligne=br.readLine())!=null){
				if(ligne.contains("$_SESSION['serveur']")){ //filtrage lignes
					outfile+=ligne+"\n";
				}
				if(ligne.contains("$_SESSION['port']")){
					outfile+=ligne+"\n";
				}
				if(ligne.contains("$_SESSION['serveur_sftp']")){
					outfile+=ligne+"\n";
				}
				if(ligne.contains("$_SESSION['port_sftp']")){
					outfile+=ligne+"\n";
				}
				if(ligne.contains("$_SESSION['limiteRam']")){
					outfile+=ligne+"\n";
				}
				if(ligne.contains("$_SESSION['limiteRom']")){
					outfile+=ligne+"\n";
				}
				if(ligne.contains("$_SESSION['limite_storagedata']")){
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
	* Voir ports service Apache
	*/
	public String listenPort_apache(){
		String outfile ="";
		String pathfile="/etc/apache2/ports.conf";
		try{
			InputStream ips = new FileInputStream(pathfile);
			InputStreamReader ipsr = new InputStreamReader(ips);
			BufferedReader br = new BufferedReader(ipsr);
			String ligne="";
			while((ligne=br.readLine())!=null){
				if(ligne.contains("Listen")){ //filtrage lignes
					if(!ligne.contains("443")){
						outfile+=ligne+"\n";
					}
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
	* Voir statut service Apache
	*/
	public void labelStatus_apache(){
		String status_apache = null;
		status_apache = new BashUtils().outputCommand("service apache2 status",""+sudopass);
		if(status_apache.contains("NOT running")){
			System.out.println("Apache Stop");
			label_status_apache.setText("Apache Stop");
			label_status_apache.setForeground(new Color(255,0,0)); //red
		}
		else if(status_apache.contains("running")){
			System.out.println("Apache Start");
			label_status_apache.setText("Apache Start");
			label_status_apache.setForeground(new Color(0,255,0));//green
		}
		else{
			System.out.println("Apache Unknow");
			label_status_apache.setText("Apache Unknow");
			label_status_apache.setForeground(new Color(255,255,0));//yellow
		}
	}

}//end of class
