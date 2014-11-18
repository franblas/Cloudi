package server;

import java.awt.Dimension;
import java.io.BufferedReader;
import java.io.FileInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;

import javax.swing.JOptionPane;
import javax.swing.JScrollPane;
import javax.swing.JTextArea;

/**
 * 
 * @author Paco
 *
 */
public class FileSystem {
	
	private String sudopass = "";
	
	/**
	 * 
	 * @param sudopass
	 */
	public FileSystem(String sudopass) {
		this.sudopass = sudopass;
	}
	
	/**
	 * 
	 * @param oldword
	 * @param newword
	 * @param pathfile
	 */
	public void changeWord(String oldword, String newword, String pathfile){
		try {
			String[] com = {"/bin/bash","-c","echo '"+sudopass+"' | sudo -S sed -i \" s/"+oldword+"/"+newword+"/g \" "+pathfile+" "};
			Runtime.getRuntime().exec(com);
			JOptionPane.showMessageDialog(null,"Changement de "+oldword+" en "+newword+" dans "+pathfile+"","Succes changement",JOptionPane.INFORMATION_MESSAGE);
		}
		catch (Exception e) {
			e.printStackTrace();
			JOptionPane.showMessageDialog(null,"Erreur de changement de mots","Erreur Cahngement",JOptionPane.INFORMATION_MESSAGE);
		}
	}

	/**
	*
	* Voir un fichier
	*
	* @param path_fichier
	*/
	public void showFile(String path_fichier){
		String outfile ="";
		try{
			InputStream ips = new FileInputStream(path_fichier);
			InputStreamReader ipsr = new InputStreamReader(ips);
			BufferedReader br = new BufferedReader(ipsr);
			String ligne="";
			while((ligne=br.readLine())!=null){
				outfile+=ligne+"\n";
			}
			br.close();
		}
		catch(IOException e){
			e.printStackTrace();
		}
		
		JTextArea textarea = new JTextArea(outfile); //remplissage panneau scrolle
		JScrollPane scrollpane = new JScrollPane(textarea); //utilisation d'un panneau scrollé pour des longs fichiers
		textarea.setLineWrap(true);
		textarea.setWrapStyleWord(true);
		scrollpane.setPreferredSize(new Dimension(500,500));
		JOptionPane.showMessageDialog(null,scrollpane,path_fichier,JOptionPane.INFORMATION_MESSAGE);
	}
	
	/**
	 * 
	 * @param pathpicture
	 * @param pathto
	 */
	public void copyfile(String pathfile, String pathto){
		try {
			String[] com = {"/bin/bash","-c","echo '"+sudopass+"' | sudo -S cp "+pathfile+"  "+pathto+""};
			Runtime.getRuntime().exec(com);
			JOptionPane.showMessageDialog(null,"Copie de "+pathfile+" vers "+pathto,"Succes Copie",JOptionPane.INFORMATION_MESSAGE);
		}
		catch (Exception e) {
			e.printStackTrace();
			JOptionPane.showMessageDialog(null,"Erreur de copie","Erreur Copie",JOptionPane.INFORMATION_MESSAGE);
		}
	}

	/**
	 * 
	 * @param pathfolder
	 * @param namefoler
	 */
	public void createfolder(String pathfolder){
		try {
			String[] com = {"/bin/bash","-c","echo '"+sudopass+"' | sudo -S mkdir "+pathfolder+""};
			Runtime.getRuntime().exec(com);
			JOptionPane.showMessageDialog(null,"Creation du dossier "+pathfolder+"","Succes Creation Dossier",JOptionPane.INFORMATION_MESSAGE);
		}
		catch (Exception e) {
			e.printStackTrace();
			JOptionPane.showMessageDialog(null,"Erreur de creation de dossier","Erreur Cretion Dossier",JOptionPane.INFORMATION_MESSAGE);
		}
	}

}//end of class
