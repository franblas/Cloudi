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
public class SshServer {
	
	private String sudopass = "";
	private JLabel label_status_ssh = null;
	
	/**
	 * 
	 * @param sudopass
	 * @param label_status_ssh
	 */
	public SshServer(String sudopass, JLabel label_status_ssh) {
		this.sudopass = sudopass;
		this.label_status_ssh = label_status_ssh;
	}

	/**
	* Voir port service SSH
	*/
	public String listenPort_ssh(){
		String outfile ="";
		String pathfile="/etc/ssh/sshd_config";
		try{
			InputStream ips = new FileInputStream(pathfile);
			InputStreamReader ipsr = new InputStreamReader(ips);
			BufferedReader br = new BufferedReader(ipsr);
			String ligne="";
			while((ligne=br.readLine())!=null){
				if(ligne.contains("Port")){ //filtrage lignes
					outfile+=ligne+"\n";
				}
				if(ligne.contains("X11Forwarding")){
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
	* Voir statut service SSH
	*/
	public void labelStatus_ssh(){
		String status_ssh = null;
		status_ssh = new BashUtils().outputCommand("service ssh status",""+sudopass);
		if(status_ssh.contains("start")){
			System.out.println("OpenSSH Start");
			label_status_ssh.setText("OpenSSH Start");
			label_status_ssh.setForeground(new Color(0,255,0)); //green
		}
		else if(status_ssh.contains("stop")){
			System.out.println("OpenSSH Stop");
			label_status_ssh.setText("OpenSSH Stop");
			label_status_ssh.setForeground(new Color(255,0,0)); //red
		}
		else{
			System.out.println("OpenSSH Unknow");
			label_status_ssh.setText("OpenSSH Unknow");
			label_status_ssh.setForeground(new Color(255,255,0)); //yellow
		}
	}

}//end of class
