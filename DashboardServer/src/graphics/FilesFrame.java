package graphics;

import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.GridLayout;
import java.awt.event.MouseEvent;
import java.awt.event.MouseListener;

import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JScrollPane;

/**
 * 
 * @author Paco
 *
 */
public class FilesFrame extends JFrame implements MouseListener{
	
	/**
	Les panneaux
	**/
	private JPanel pan = new JPanel(); //Panneau principal
	private JPanel pan4 = new JPanel();
	
	/**
	 * Les boutons
	 */
	private JButton bouton_lshell = new JButton(); //bouton 
	private JButton bouton_sshd = new JButton(); //bouton 
	private JButton bouton_sftp= new JButton(); //bouton 
	private JButton bouton_sitecloudi = new JButton(); //bouton 
	private JButton bouton_pageperso = new JButton(); //bouton 
	private JButton bouton_stylefirefox = new JButton(); //bouton 
	private JButton bouton_stylechrome = new JButton(); //bouton 
	
	/**
	 * Useful
	 */
	private String sudopass = "";
	
	/**
	 * 
	 * @param nom
	 * @param largeur
	 * @param hauteur
	 */
	public FilesFrame(String nom,int largeur, int hauteur, String passsudo){
		this.sudopass = passsudo;
		
		//Frame options
		this.setTitle(nom); //Titre de la Fenetre
		this.setSize(largeur,hauteur); //taille de la fen�tre en pixels
		this.setBackground(Color.WHITE); //Fond de la fen�tre
		this.setLocationRelativeTo(null); //Positionnement au centre
		this.setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE); //Termine le processus lorsqu'on clique sur la croix rouge
		this.setResizable(false); //Empeche/Autorise redimensionnement
		this.setAlwaysOnTop(false); //Toujours/Jamais au 1er plan
		
		//boutons configuration
		bouton_lshell.setToolTipText("Modifier lshell.conf"); //Message au passage du curseur
		bouton_lshell.setText("Limited Shell"); //Titre du bouton
		bouton_sshd.setToolTipText("Modifier sshd_config"); //Message au passage du curseur
		bouton_sshd.setText("SSH"); //Titre du bouton
		bouton_sftp.setToolTipText("Modifier sftp_config"); //Message au passage du curseur
		bouton_sftp.setText("SFTP"); //Titre du bouton
		bouton_sitecloudi.setToolTipText("Modifier virtualhost cloudi"); //Message au passage du curseur
		bouton_sitecloudi.setText("VirtualHost Web"); //Titre du bouton
		bouton_pageperso.setToolTipText("Modifier pageperso.php"); //Message au passage du curseur
		bouton_pageperso.setText("Page Perso"); //Titre du bouton
		bouton_stylefirefox.setToolTipText("Modifier stylefirefox.css"); //Message au passage du curseur
		bouton_stylefirefox.setText("Style Firefox"); //Titre du bouton
		bouton_stylechrome.setToolTipText("Modifier stylechrome.css"); //Message au passage du curseur
		bouton_stylechrome.setText("Style Chrome"); //Titre du bouton
		
		bouton_lshell.addMouseListener(this);
		bouton_sshd.addMouseListener(this);
		bouton_sftp.addMouseListener(this);
		bouton_sitecloudi.addMouseListener(this);
		bouton_pageperso.addMouseListener(this);
		bouton_stylefirefox.addMouseListener(this);
		bouton_stylechrome.addMouseListener(this);
		
		//layout configuration
		GridLayout gridpan1 = new GridLayout(0,1);
		GridLayout gridpan2 = new GridLayout(0,3);
		pan.setLayout(gridpan1);
		pan4.setLayout(gridpan2);
		
		//add components to panels
		pan4.add(bouton_lshell);
		pan4.add(bouton_sshd);
		pan4.add(bouton_sftp);
		pan4.add(bouton_sitecloudi);
		pan4.add(bouton_pageperso);
		pan4.add(bouton_stylefirefox);
		pan4.add(bouton_stylechrome);
		
		pan.add(pan4);
		
		this.getContentPane().add(new JScrollPane(pan),BorderLayout.CENTER);

		this.setVisible(true);
		
	}
	
	/**
	 * 
	 * @param path
	 */
	public void geditRun(String path){
		try {
			String[] com = {"/bin/bash","-c","echo '"+sudopass+"' | sudo -S gedit "+path};
			//String[] com = {"/bin/bash","-c","echo '"+"sunpaco35@P"+"' | sudo -S gedit "+path};
			Runtime.getRuntime().exec(com);
		}
		catch (Exception e) {
			e.printStackTrace();
			JOptionPane.showMessageDialog(null,"Erreur au demarrage d'Apache","Erreur Apache",JOptionPane.INFORMATION_MESSAGE);
		}
	}
	
	@Override
	public void mouseClicked(MouseEvent e) {
		if(e.getSource() == bouton_lshell){
			geditRun("/etc/lshell.conf");
		}//fin if
		if(e.getSource() == bouton_sshd){
			geditRun("/etc/ssh/sshd_config");
		}
		if(e.getSource() == bouton_sftp){
			geditRun("/etc/ssh/sftp_config");
		}
		if(e.getSource() == bouton_sitecloudi){
			geditRun("/etc/apache2/sites-available/cloudi");
		}
		if(e.getSource() == bouton_pageperso){
			geditRun("/var/www/pageperso.php");
		}
		if(e.getSource() == bouton_stylefirefox){
			geditRun("/var/www/stylefirefox.css");
		}
		if(e.getSource() == bouton_stylechrome){
			geditRun("/var/www/stylechrome.css");
		}	
	}
	
	@Override
	public void mouseEntered(MouseEvent arg0) {		
	}
	
	@Override
	public void mouseExited(MouseEvent arg0) {		
	}
	
	@Override
	public void mousePressed(MouseEvent arg0) {	
	}
	
	@Override
	public void mouseReleased(MouseEvent arg0) {
	}

}//end of class
